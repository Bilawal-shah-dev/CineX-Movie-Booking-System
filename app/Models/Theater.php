<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Theater extends Model {
    use HasFactory;

    protected $fillable = [
        'name', 'city', 'address',
        'total_seats', 'facilities', 'image', 'is_active'
    ];

    protected $casts = ['is_active' => 'boolean'];

    public function shows() {
        return $this->hasMany(Show::class);
    }
}