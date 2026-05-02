<?php

namespace App\Http\Controllers;

use App\Models\Show;
use Illuminate\Http\Request;

class ShowController extends Controller
{
    // Booked seats API — AJAX call karta hai seat map
    public function bookedSeats($showId)
    {
        $show  = Show::findOrFail($showId);
        $seats = $show->getBookedSeats();
        return response()->json([
            'booked_seats' => $seats,
            'show_id'      => $showId,
        ]);
    }
}