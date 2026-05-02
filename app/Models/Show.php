<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Show extends Model
{
    use HasFactory;

    protected $fillable = [
        'movie_id','theater_id','show_date','show_time',
        'gold_price','platinum_price','box_price',
        'available_seats','is_active'
    ];

    protected $casts = [
        'show_date' => 'date',
        'is_active' => 'boolean',
    ];

    public function movie()   { return $this->belongsTo(Movie::class); }
    public function theater() { return $this->belongsTo(Theater::class); }
    public function bookings(){ return $this->hasMany(Booking::class); }

    // Show khatam hua ya nahi
    public function isExpired(): bool
    {
        $showDateTime = Carbon::parse(
            $this->show_date->format('Y-m-d') . ' ' . $this->show_time
        );
        return now()->isAfter($showDateTime);
    }

    // Booked seats — expired shows ki seats count nahi hongi
    public function getBookedSeats(): array
    {
        // Agar show khatam ho gaya — koi bhi seat booked nahi
        if ($this->isExpired()) {
            return [];
        }

        $seats = [];
        foreach ($this->bookings()
                      ->where('status','confirmed')
                      ->where('payment_status','paid')
                      ->get() as $b) {
            $seats = array_merge($seats, $b->seat_numbers ?? []);
        }
        return array_unique($seats);
    }
}