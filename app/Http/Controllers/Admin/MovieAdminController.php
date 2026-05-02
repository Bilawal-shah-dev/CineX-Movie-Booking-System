<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MovieAdminController extends Controller
{
    public function index()
    {
        $movies = Movie::latest()->paginate(15);
        return view('admin.movies.index', compact('movies'));
    }

    public function create()
    {
        return view('admin.movies.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'            => 'required|string|max:200',
            'description'      => 'required|string',
            'genre'            => 'required|string',
            'language'         => 'required|string',
            'duration_minutes' => 'required|integer|min:1',
            'release_date'     => 'required|date',
            'age_rating'       => 'required|string',
            'status'           => 'required|in:now_showing,coming_soon,ended',
            'poster_image'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            'trailer_url'      => 'nullable|url',
            'cast'             => 'nullable|string',
            'director'         => 'nullable|string',
        ]);

        $data = $request->except('poster_image');
        $data['slug'] = Str::slug($request->title) . '-' . Str::random(4);

        if ($request->hasFile('poster_image')) {
    $file = $request->file('poster_image');
    $name = \Illuminate\Support\Str::slug($request->title).'-'.time().'.'.$file->getClientOriginalExtension();
    
    // Folder banao agar nahi hai
    if (!file_exists(public_path('images/posters'))) {
        mkdir(public_path('images/posters'), 0755, true);
    }
    
    $file->move(public_path('images/posters'), $name);
    $data['poster_image'] = $name; // Sirf filename — path nahi
}

        Movie::create($data);

        return redirect()->route('admin.movies.index')
                         ->with('success', 'Movie added successfully!');
    }

    public function edit($id)
    {
        $movie = Movie::findOrFail($id);
        return view('admin.movies.edit', compact('movie'));
    }

    public function update(Request $request, $id)
    {
        $movie = Movie::findOrFail($id);

        $request->validate([
            'title'            => 'required|string|max:200',
            'description'      => 'required|string',
            'genre'            => 'required|string',
            'language'         => 'required|string',
            'duration_minutes' => 'required|integer|min:1',
            'release_date'     => 'required|date',
            'age_rating'       => 'required|string',
            'status'           => 'required|in:now_showing,coming_soon,ended',
            'poster_image'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            'trailer_url'      => 'nullable|url',
        ]);

        $data = $request->except('poster_image');

        if ($request->hasFile('poster_image')) {
            // Delete old image
            if ($movie->poster_image && file_exists(public_path('images/posters/'.$movie->poster_image))) {
                unlink(public_path('images/posters/'.$movie->poster_image));
            }
            $file = $request->file('poster_image');
            $name = Str::slug($request->title) . '-' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/posters'), $name);
            $data['poster_image'] = $name;
        }

        $movie->update($data);

        return redirect()->route('admin.movies.index')
                         ->with('success', 'Movie updated successfully!');
    }

    public function destroy($id)
    {
        $movie = Movie::findOrFail($id);
        if ($movie->poster_image && file_exists(public_path('images/posters/'.$movie->poster_image))) {
            unlink(public_path('images/posters/'.$movie->poster_image));
        }
        $movie->delete();
        return back()->with('success', 'Movie deleted.');
    }
}