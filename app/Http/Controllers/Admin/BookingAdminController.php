<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['user','show.movie','show.theater'])->latest();

        if ($request->filled('search')) {
            $query->where('booking_id','like','%'.$request->search.'%')
                  ->orWhereHas('user', fn($q) => $q->where('name','like','%'.$request->search.'%'));
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $bookings = $query->paginate(20);
        return view('admin.bookings.index', compact('bookings'));
    }
}