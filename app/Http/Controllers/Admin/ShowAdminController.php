<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Show;
use App\Models\Movie;
use App\Models\Theater;
use Illuminate\Http\Request;

class ShowAdminController extends Controller
{
    public function index()
    {
        $shows    = Show::with(['movie','theater'])->latest()->paginate(20);
        $movies   = Movie::where('is_active',true)->get();
        $theaters = Theater::where('is_active',true)->get();
        return view('admin.shows.index', compact('shows','movies','theaters'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'movie_id'        => 'required|exists:movies,id',
            'theater_id'      => 'required|exists:theaters,id',
            'show_date'       => 'required|date|after_or_equal:today',
            'show_time'       => 'required',
            'gold_price'      => 'required|numeric|min:0',
            'platinum_price'  => 'required|numeric|min:0',
            'box_price'       => 'required|numeric|min:0',
        ]);

        Show::create([
            'movie_id'        => $request->movie_id,
            'theater_id'      => $request->theater_id,
            'show_date'       => $request->show_date,
            'show_time'       => $request->show_time,
            'gold_price'      => $request->gold_price,
            'platinum_price'  => $request->platinum_price,
            'box_price'       => $request->box_price,
            'available_seats' => 168,
            'is_active'       => true,
        ]);

        return back()->with('success', 'Show added!');
    }

    public function destroy($id)
    {
        Show::findOrFail($id)->delete();
        return back()->with('success', 'Show deleted.');
    }
}