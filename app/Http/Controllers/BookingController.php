<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Show;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function seats($showId)
    {
        $show = Show::with(['movie', 'theater'])->findOrFail($showId);

        if (!$show->is_active) {
            return redirect()->route('movies.show', $show->movie->slug)
                             ->with('error', 'This show is no longer available.');
        }

        $bookedSeats = $show->getBookedSeats();
        return view('user.booking.seat-select', compact('show', 'bookedSeats'));
    }

    public function summary(Request $request)
    {
        $request->validate([
            'show_id'      => 'required|exists:shows,id',
            'seat_numbers' => 'required|string',
            'seat_class'   => 'required|in:gold,platinum,box',
            'kids_count'   => 'nullable|integer|min:0',
        ]);

        $show        = Show::with(['movie', 'theater'])->findOrFail($request->show_id);
        $seatNumbers = array_values(array_filter(explode(',', $request->seat_numbers)));
        $seatClass   = $request->seat_class;
        $kidsCount   = (int)($request->kids_count ?? 0);
        $numSeats    = count($seatNumbers);

        if ($numSeats === 0) {
            return back()->with('error', 'Please select at least one seat.');
        }

        $priceMap    = [
            'gold'     => (float)$show->gold_price,
            'platinum' => (float)$show->platinum_price,
            'box'      => (float)$show->box_price,
        ];
        $unitPrice   = $priceMap[$seatClass];
        $adultCount  = max(0, $numSeats - $kidsCount);
        $totalAmount = ($adultCount * $unitPrice) + ($kidsCount * $unitPrice * 0.5);

        session(['booking_data' => [
            'show_id'      => $show->id,
            'seat_numbers' => $seatNumbers,
            'seat_class'   => $seatClass,
            'num_seats'    => $numSeats,
            'kids_count'   => $kidsCount,
            'total_amount' => $totalAmount,
            'unit_price'   => $unitPrice,
        ]]);

        return view('user.booking.summary', compact(
            'show', 'seatNumbers', 'seatClass',
            'kidsCount', 'totalAmount', 'unitPrice', 'numSeats'
        ));
    }

    public function history()
    {
        $bookings = auth()->user()
                          ->bookings()
                          ->with(['show.movie', 'show.theater'])
                          ->latest()
                          ->get();
        return view('user.profile.bookings', compact('bookings'));
    }

 
 public function cancelSeats(Request $request, $id)
{
    $booking = Booking::with('show')->findOrFail($id);

    if ($booking->user_id !== auth()->id()) {
        abort(403);
    }

    if ($booking->status === 'cancelled') {
        return back()->with('error', 'This booking is already fully cancelled.');
    }

    $showDateTime = \Carbon\Carbon::parse(
        $booking->show->show_date->format('Y-m-d') . ' ' . $booking->show->show_time
    );

    if (now()->diffInMinutes($showDateTime, false) < 60) {
        return back()->with('error',
            'Cancellation only allowed up to 1 hour before show time. '
            . 'Show starts at ' . $showDateTime->format('h:i A, d M Y')
        );
    }

    $request->validate([
        'cancel_seats'   => 'required|array|min:1',
        'cancel_seats.*' => 'string',
    ]);

    // Normalize all to strings for comparison
    $seatsToCancel  = array_map('strval', array_values($request->cancel_seats));
    $activeSeats    = array_map('strval', array_values(
        (array)($booking->active_seats ?? $booking->seat_numbers ?? [])
    ));
    $cancelledSeats = array_map('strval', array_values(
        (array)($booking->cancelled_seats ?? [])
    ));

    // Validate seats exist in active
    $invalid = array_diff($seatsToCancel, $activeSeats);
    if (!empty($invalid)) {
        return back()->with('error', 'Invalid seats: ' . implode(', ', $invalid));
    }

    // Calculate new active seats
    $newActive = array_values(
        array_filter($activeSeats, function ($s) use ($seatsToCancel) {
            return !in_array($s, $seatsToCancel, true);
        })
    );
    $newCancelled  = array_values(array_merge($cancelledSeats, $seatsToCancel));
    $isFullCancel  = count($newActive) === 0;
    $cancelCount   = count($seatsToCancel);

    // Recalculate amount
    $priceMap = [
        'gold'     => (float)$booking->show->gold_price,
        'platinum' => (float)$booking->show->platinum_price,
        'box'      => (float)$booking->show->box_price,
    ];
    $unitPrice     = $priceMap[$booking->seat_class] ?? 0;
    $remainKids    = $isFullCancel ? 0 : min((int)$booking->kids_count, count($newActive));
    $newTotal      = $isFullCancel ? 0
        : ((count($newActive) - $remainKids) * $unitPrice + $remainKids * $unitPrice * 0.5);
    $refundAmount  = $cancelCount * $unitPrice;

    $booking->update([
        'active_seats'    => $newActive,
        'cancelled_seats' => $newCancelled,
        'num_seats'       => count($newActive),
        'kids_count'      => $remainKids,
        'total_amount'    => $newTotal,
        'status'          => $isFullCancel ? 'cancelled' : 'confirmed',
        'payment_status'  => $isFullCancel ? 'refunded'  : 'paid',
    ]);

    $booking->show->increment('available_seats', $cancelCount);

    return redirect()
        ->route('booking.confirm', $booking->id)
        ->with('cancel_success',
            $cancelCount . ' seat(s) cancelled successfully. '
            . 'Rs. ' . number_format($refundAmount)
            . ' refund will be processed within 3–5 business days.'
        );
}
}