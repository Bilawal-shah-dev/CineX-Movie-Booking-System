<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('genre');
            $table->string('language')->default('Urdu');
            $table->integer('duration_minutes');
            $table->date('release_date');
            $table->string('age_rating')->default('PG-13');
            $table->string('poster_image')->nullable();
            $table->string('trailer_url')->nullable();
            $table->string('cast')->nullable();
            $table->string('director')->nullable();
            $table->decimal('avg_rating', 3, 2)->default(0.00);
            $table->enum('status', ['coming_soon', 'now_showing', 'ended'])->default('coming_soon');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('movies');
    }
};