<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('bookings', function (Blueprint $table) {
            // Change booking_id format
            $table->string('booking_id', 30)->change();
            // Track which specific seats are cancelled
            $table->json('cancelled_seats')->nullable()->after('seat_numbers');
            $table->json('active_seats')->nullable()->after('cancelled_seats');
        });
    }
    public function down(): void {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['cancelled_seats','active_seats']);
        });
    }
};