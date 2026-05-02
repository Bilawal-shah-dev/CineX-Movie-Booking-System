<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function about()   { return view('pages.about'); }
    public function contact() { return view('pages.contact'); }
    public function terms()   { return view('pages.terms'); }
    public function privacy() { return view('pages.privacy'); }
    public function team()    { return view('pages.team'); }
    public function careers() { return view('pages.careers'); }
    public function faq()     { return view('pages.faq'); }

    public function contactSubmit(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'required|email',
            'subject' => 'required|string|max:200',
            'message' => 'required|string|max:2000',
        ]);
        \Log::info('Contact:', $request->only(['name','email','subject','message']));
        return back()->with('success', 'Message received! We\'ll reply within 24 hours.');
    }
}