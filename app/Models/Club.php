<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'sport_id'];


    public function players(){
        return $this->belongsToMany('App\Player');
    }

    public function sports(){
        return $this->belongsToMany('App\Sport');
    }
}
