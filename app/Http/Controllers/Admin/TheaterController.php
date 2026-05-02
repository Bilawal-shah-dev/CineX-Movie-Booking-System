<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Theater;
use Illuminate\Http\Request;

class TheaterController extends Controller
{
    public function index()
    {
        $theaters = Theater::withCount('shows')->latest()->get();
        return view('admin.theaters.index', compact('theaters'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:150',
            'city'        => 'required|string|max:100',
            'address'     => 'required|string',
            'total_seats' => 'required|integer|min:1',
            'facilities'  => 'nullable|string',
        ]);
        Theater::create($request->all());
        return back()->with('success', 'Theater added!');
    }

    public function update(Request $request, $id)
    {
        $theater = Theater::findOrFail($id);
        $request->validate([
            'name'    => 'required|string|max:150',
            'city'    => 'required|string|max:100',
            'address' => 'required|string',
        ]);
        $theater->update($request->all());
        return back()->with('success', 'Theater updated!');
    }

    public function destroy($id)
    {
        Theater::findOrFail($id)->delete();
        return back()->with('success', 'Theater deleted.');
    }
}