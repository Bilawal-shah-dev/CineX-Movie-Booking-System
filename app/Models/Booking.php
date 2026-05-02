<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id','user_id','show_id',
        'seat_numbers','cancelled_seats','active_seats',
        'seat_class','num_seats','kids_count','total_amount',
        'payment_method','payment_status','status'
    ];

    protected $casts = [
        'seat_numbers'    => 'array',
        'cancelled_seats' => 'array',
        'active_seats'    => 'array',
    ];

    public function user()  { return $this->belongsTo(User::class); }
    public function show()  { return $this->belongsTo(Show::class); }

    // Active seats = all seats minus cancelled
    public function getActiveSeatsAttribute($value): array
    {
        if ($value) return json_decode($value, true) ?? [];
        return $this->seat_numbers ?? [];
    }

    // Is fully cancelled?
    public function isFullyCancelled(): bool
    {
        return $this->status === 'cancelled';
    }

    // Is partially cancelled?
    public function isPartiallyCancelled(): bool
    {
        $cancelled = $this->cancelled_seats ?? [];
        return count($cancelled) > 0 && $this->status !== 'cancelled';
    }
}