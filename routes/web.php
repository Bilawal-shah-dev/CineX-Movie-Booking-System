<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ShowController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MovieAdminController;
use App\Http\Controllers\Admin\TheaterController;
use App\Http\Controllers\Admin\ShowAdminController;
use App\Http\Controllers\Admin\BookingAdminController;
use App\Http\Controllers\Admin\UserAdminController;

// ================================================================
// PUBLIC ROUTES
// ================================================================
Route::get('/', function () {
    $nowShowing = \App\Models\Movie::where('status','now_showing')->where('is_active',true)->take(5)->get();
    $comingSoon = \App\Models\Movie::where('status','coming_soon')->where('is_active',true)->take(5)->get();
    return view('home', compact('nowShowing','comingSoon'));
})->name('home');

Route::get('/movies',        [MovieController::class,'index'])->name('movies.index');
Route::get('/movies/{slug}', [MovieController::class,'show'])->name('movies.show');

// Static/Company Pages
Route::get('/about',      [PageController::class,'about'])->name('pages.about');
Route::get('/contact',    [PageController::class,'contact'])->name('pages.contact');
Route::post('/contact',   [PageController::class,'contactSubmit'])->name('pages.contact.submit');
Route::get('/terms',      [PageController::class,'terms'])->name('pages.terms');
Route::get('/privacy',    [PageController::class,'privacy'])->name('pages.privacy');
Route::get('/team',       [PageController::class,'team'])->name('pages.team');
Route::get('/careers',    [PageController::class,'careers'])->name('pages.careers');
Route::get('/faq',        [PageController::class,'faq'])->name('pages.faq');

// ================================================================
// AUTHENTICATED ROUTES
// ================================================================
Route::middleware('auth')->group(function () {
    Route::post('/reviews',           [ReviewController::class,'store'])->name('reviews.store');
    Route::get('/profile',            [ProfileController::class,'index'])->name('profile.index');
    Route::put('/profile',            [ProfileController::class,'update'])->name('profile.update');
    Route::get('/my-bookings',        [BookingController::class,'history'])->name('bookings.history');

    Route::get('/booking/{showId}/seats',      [BookingController::class,'seats'])->name('booking.seats');
    Route::post('/booking/summary',            [BookingController::class,'summary'])->name('booking.summary');
    Route::get('/booking/summary',             fn() => redirect()->route('movies.index'))->name('booking.summary.show');
    Route::get('/booking/{id}/confirm',        [PaymentController::class,'confirm'])->name('booking.confirm');
    Route::patch('/booking/{id}/cancel-seats', [BookingController::class,'cancelSeats'])->name('booking.cancel-seats');

    Route::get('/payment',            [PaymentController::class,'index'])->name('payment.index');
    Route::post('/payment/process',   [PaymentController::class,'process'])->name('payment.process');

    Route::get('/api/shows/{showId}/booked-seats', [ShowController::class,'bookedSeats'])->name('shows.booked-seats');
});

// ================================================================
// ADMIN ROUTES
// ================================================================
Route::middleware(['auth','admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard',          [DashboardController::class,'index'])->name('dashboard');

    Route::get('/movies',             [MovieAdminController::class,'index'])->name('movies.index');
    Route::get('/movies/create',      [MovieAdminController::class,'create'])->name('movies.create');
    Route::post('/movies',            [MovieAdminController::class,'store'])->name('movies.store');
    Route::get('/movies/{id}/edit',   [MovieAdminController::class,'edit'])->name('movies.edit');
    Route::put('/movies/{id}',        [MovieAdminController::class,'update'])->name('movies.update');
    Route::delete('/movies/{id}',     [MovieAdminController::class,'destroy'])->name('movies.destroy');

    Route::get('/theaters',           [TheaterController::class,'index'])->name('theaters.index');
    Route::post('/theaters',          [TheaterController::class,'store'])->name('theaters.store');
    Route::put('/theaters/{id}',      [TheaterController::class,'update'])->name('theaters.update');
    Route::delete('/theaters/{id}',   [TheaterController::class,'destroy'])->name('theaters.destroy');

    Route::get('/shows',              [ShowAdminController::class,'index'])->name('shows.index');
    Route::post('/shows',             [ShowAdminController::class,'store'])->name('shows.store');
    Route::delete('/shows/{id}',      [ShowAdminController::class,'destroy'])->name('shows.destroy');

    Route::get('/bookings',           [BookingAdminController::class,'index'])->name('bookings.index');
    Route::get('/users',              [UserAdminController::class,'index'])->name('users.index');
});

require __DIR__.'/auth.php';