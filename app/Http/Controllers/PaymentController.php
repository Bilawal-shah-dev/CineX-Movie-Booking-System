<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Show;
use App\Helpers\BookingIdGenerator;
use App\Mail\BookingConfirmationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PaymentController extends Controller
{
    public function index()
    {
        $bookingData = session('booking_data');
        if (!$bookingData) {
            return redirect()->route('movies.index')->with('error','Session expired. Please start again.');
        }
        $show = Show::with(['movie','theater'])->findOrFail($bookingData['show_id']);
        return view('user.booking.payment', compact('bookingData','show'));
    }

    public function process(Request $request)
    {
        $request->validate(['payment_method' => 'required|in:jazzcash,easypaisa,card']);

        $bookingData = session('booking_data');
        if (!$bookingData) {
            return redirect()->route('movies.index')->with('error','Session expired.');
        }

        $show        = Show::findOrFail($bookingData['show_id']);
        $bookedSeats = $show->getBookedSeats();
        $conflict    = array_intersect($bookingData['seat_numbers'], $bookedSeats);

        if ($conflict) {
            session()->forget('booking_data');
            return redirect()->route('booking.seats', $show->id)
                             ->with('error','Some seats were just booked. Please reselect.');
        }

        $bookingId = BookingIdGenerator::generate();

        $booking = Booking::create([
            'booking_id'     => $bookingId,
            'user_id'        => auth()->id(),
            'show_id'        => $bookingData['show_id'],
            'seat_numbers'   => $bookingData['seat_numbers'],
            'active_seats'   => $bookingData['seat_numbers'],
            'cancelled_seats'=> [],
            'seat_class'     => $bookingData['seat_class'],
            'num_seats'      => $bookingData['num_seats'],
            'kids_count'     => $bookingData['kids_count'],
            'total_amount'   => $bookingData['total_amount'],
            'payment_method' => $request->payment_method,
            'payment_status' => 'paid',
            'status'         => 'confirmed',
        ]);

        $show->decrement('available_seats', $bookingData['num_seats']);
        session()->forget('booking_data');

        try {
            Mail::to(auth()->user()->email)
                ->send(new BookingConfirmationMail(
                    $booking->load(['show.movie','show.theater','user'])
                ));
        } catch (\Exception $e) {
            \Log::error('Mail failed: '.$e->getMessage());
        }

        return redirect()->route('booking.confirm', $booking->id);
    }

    public function confirm($bookingId)
    {
        $booking = Booking::with(['show.movie','show.theater','user'])
                          ->findOrFail($bookingId);

        if ($booking->user_id !== auth()->id()) abort(403);

        return view('user.booking.confirm', compact('booking'));
    }
}