<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Sport extends Model
{
    use HasFactory;
    protected $fillable = ['nameSport'];

    public function club(): BelongsToMany
    {
        return $this->belongstoMany(
            Sport::class,
            'club_sport',
            'club',
            'sport'
        );
    }
}
