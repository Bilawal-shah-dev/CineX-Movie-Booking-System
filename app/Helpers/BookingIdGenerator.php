<?php

namespace App\Helpers;

use App\Models\Booking;

class BookingIdGenerator
{
    /**
     * Format: CX-01102006-000001
     * CX = CineX
     * 01102006 = date (DDMMYYYY)
     * 000001 = daily sequence (max 10000)
     */
    public static function generate(): string
    {
        $datePart = now()->format('d') . now()->format('m') . now()->format('Y');

        // Count today's bookings to get sequence
        $todayCount = Booking::whereDate('created_at', today())->count();
        $sequence   = str_pad($todayCount + 1, 6, '0', STR_PAD_LEFT);

        return 'CX-' . $datePart . '-' . $sequence;
    }
}