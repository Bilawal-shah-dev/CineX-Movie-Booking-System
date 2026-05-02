<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Movie extends Model {
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'genre', 'language',
        'duration_minutes', 'release_date', 'age_rating',
        'poster_image', 'trailer_url', 'cast', 'director',
        'avg_rating', 'status', 'is_active', 'slug'
    ];

    protected $casts = [
        'release_date' => 'date',
        'is_active'    => 'boolean',
        'avg_rating'   => 'decimal:2',
    ];

    // Boot method — auto slug generate
    protected static function boot()
    {
    parent::boot();
    static::creating(function ($movie) {
        $movie->slug = Str::slug($movie->title) . '-' . Str::random(4);
    });
    }

    public function shows() {
        return $this->hasMany(Show::class);
    }

    public function reviews() {
        return $this->hasMany(Review::class);
    }

    public function updateAvgRating() {
        $this->avg_rating = $this->reviews()->avg('rating') ?? 0;
        $this->save();
    }

    // Route model binding
    public function getRouteKeyName()
    {
    return 'slug';
    }
}
