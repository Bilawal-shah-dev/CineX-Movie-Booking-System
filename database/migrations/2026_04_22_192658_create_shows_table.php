<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('shows', function (Blueprint $table) {
            $table->id();
            $table->foreignId('movie_id')->constrained()->onDelete('cascade');
            $table->foreignId('theater_id')->constrained()->onDelete('cascade');
            $table->date('show_date');
            $table->time('show_time');
            $table->decimal('gold_price', 8, 2)->default(800);
            $table->decimal('platinum_price', 8, 2)->default(1200);
            $table->decimal('box_price', 8, 2)->default(2000);
            $table->integer('available_seats')->default(168);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('shows');
    }
};