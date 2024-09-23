<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;

    protected $fillable = [
        'position',
        'batting_average',
        'home_runs',
        'RBIs',
        'stolen_bases',
        'ERA',
        'strikeouts',
        'walks',
        'fielding_percentage',
    ];
}
