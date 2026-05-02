<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Movie;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'movie_id' => 'required|exists:movies,id',
            'rating'   => 'required|integer|min:1|max:5',
            'review_text' => 'nullable|string|max:1000',
        ]);

        $existing = Review::where('user_id', auth()->id())
                          ->where('movie_id', $request->movie_id)
                          ->first();

        if ($existing) {
            return back()->with('error', 'Aap pehle hi yeh movie review kar chuke hain.');
        }

        Review::create([
            'user_id'     => auth()->id(),
            'movie_id'    => $request->movie_id,
            'rating'      => $request->rating,
            'review_text' => $request->review_text,
        ]);

        $movie = Movie::find($request->movie_id);
        $movie->updateAvgRating();

        return back()->with('success', 'Review submit ho gaya! Shukriya.');
    }
}