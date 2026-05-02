<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_id')->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('show_id')->constrained()->onDelete('cascade');
            $table->json('seat_numbers');
            $table->enum('seat_class', ['gold', 'platinum', 'box']);
            $table->integer('num_seats');
            $table->integer('kids_count')->default(0);
            $table->decimal('total_amount', 10, 2);
            $table->enum('payment_method', ['jazzcash', 'easypaisa', 'card'])->nullable();
            $table->enum('payment_status', ['pending', 'paid', 'failed'])->default('pending');
            $table->enum('status', ['confirmed', 'cancelled'])->default('confirmed');
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('bookings');
    }
};