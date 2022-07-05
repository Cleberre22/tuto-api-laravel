<?php

namespace App\Models;

use App\Models\Club;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;
    protected $fillable = ['firstName', 'lastName', 'height', 'position', 'club_id'];

    public function clubs()
    {
        return $this->hasMany('App\Club');
    }
}
