<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function index(Request $request)
    {
        $query = Movie::where('is_active', true);

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('genre')) {
            $query->where('genre', $request->genre);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('rating')) {
            $query->where('avg_rating', '>=', $request->rating);
        }

        $movies     = $query->latest()->paginate(12);
        $nowShowing = Movie::where('status','now_showing')->where('is_active',true)->take(6)->get();
        $comingSoon = Movie::where('status','coming_soon')->where('is_active',true)->take(4)->get();
        $genres     = Movie::distinct()->pluck('genre');

        return view('user.movies.index', compact('movies','nowShowing','comingSoon','genres'));
    }

    public function show($slug)
    {
        // Slug ya ID dono se kaam kare
        $movie = Movie::where('slug', $slug)
                      ->orWhere('id', is_numeric($slug) ? $slug : 0)
                      ->firstOrFail();

        $reviews = $movie->reviews()->with('user')->latest()->get();

        // Shows grouped by date — sirf aaj se aage wale
        $shows = $movie->shows()
                       ->with('theater')
                       ->where('show_date', '>=', today())
                       ->where('is_active', true)
                       ->orderBy('show_date')
                       ->orderBy('show_time')
                       ->get()
                       ->groupBy(fn($s) => $s->show_date->format('Y-m-d'));

        $related = Movie::where('genre', $movie->genre)
                        ->where('id', '!=', $movie->id)
                        ->where('is_active', true)
                        ->take(4)->get();

        return view('user.movies.show', compact('movie','reviews','shows','related'));
    }
}