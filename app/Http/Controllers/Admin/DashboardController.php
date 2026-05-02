<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Movie;
use App\Models\User;
use App\Models\Show;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_bookings'  => Booking::where('status','confirmed')->count(),
            'total_revenue'   => Booking::where('payment_status','paid')->sum('total_amount'),
            'total_movies'    => Movie::where('is_active',true)->count(),
            'total_users'     => User::where('is_admin',false)->count(),
            'today_bookings'  => Booking::whereDate('created_at',today())->where('status','confirmed')->count(),
            'now_showing'     => Movie::where('status','now_showing')->count(),
        ];

        // Weekly bookings for chart
        $weeklyBookings = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $weeklyBookings[] = [
                'day'   => $date->format('D'),
                'count' => Booking::whereDate('created_at', $date)->where('status','confirmed')->count(),
                'rev'   => Booking::whereDate('created_at', $date)->where('payment_status','paid')->sum('total_amount'),
            ];
        }

        // Top movies
        $topMovies = Movie::withCount(['shows as bookings_count' => function($q) {
            $q->join('bookings','bookings.show_id','=','shows.id')
              ->where('bookings.status','confirmed');
        }])->orderByDesc('bookings_count')->take(5)->get();

        // Recent bookings
        $recentBookings = Booking::with(['user','show.movie'])
                                 ->latest()->take(8)->get();

        return view('admin.dashboard', compact(
            'stats','weeklyBookings','topMovies','recentBookings'
        ));
    }
}