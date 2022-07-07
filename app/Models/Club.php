<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Club extends Model
{
    use HasFactory;
    protected $fillable = ['name'];


    public function players(){
        return $this->belongsToMany('App\Player');
    }

    public function sport(): BelongsToMany
    {
        return $this->belongstoMany(
            Club::class,
            'sport_club',
            'sport',
            'club'
        );
    }
}
