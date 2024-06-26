<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Episodes extends Model
{
    use HasFactory;

    protected $table = 'episodes';

    protected $fillable = [
        'name',
        'air_date',
        'episode',
        'url',
    ];

    public function characters()
    {
        return $this->belongsToMany(Characters::class, 'character_episode', 'episode_id', 'character_id');
    }
}
