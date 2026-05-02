<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    public function index()
    {
        $user     = auth()->user();
        $bookings = $user->bookings()
                         ->with(['show.movie','show.theater'])
                         ->latest()->get();
        return view('user.profile.index', compact('user','bookings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name'   => 'required|string|max:100',
            'phone'  => 'nullable|string|max:20',
            'dob'    => 'nullable|date',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = [
            'name'  => $request->name,
            'phone' => $request->phone,
            'dob'   => $request->dob,
        ];

        if ($request->hasFile('avatar')) {
            // Delete old avatar
            $oldAvatar = auth()->user()->avatar;
            if ($oldAvatar && file_exists(public_path('images/avatars/'.$oldAvatar))) {
                unlink(public_path('images/avatars/'.$oldAvatar));
            }

            // Save new
            $file = $request->file('avatar');
            $name = 'user-'.auth()->id().'-'.time().'.'.$file->getClientOriginalExtension();

            // Create folder if not exists
            if (!file_exists(public_path('images/avatars'))) {
                mkdir(public_path('images/avatars'), 0755, true);
            }

            $file->move(public_path('images/avatars'), $name);
            $data['avatar'] = $name;
        }

        auth()->user()->update($data);

        return back()->with('success', 'Profile updated successfully!');
    }
}