<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'first_name',
        'last_name',
        'age',
        'position',
        'rating_arm',
        'rating_speed',
        'rating_hitting',
        'rating_fielding',
        'rating_pitching',
    ];

    protected $casts = [
        'pitches' => 'array',
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}
