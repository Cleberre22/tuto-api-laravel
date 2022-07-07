<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sport extends Model
{
    use HasFactory;
    protected $fillable = ['nameSport'];

    public function clubs(){
        return $this->belongsToMany('App\Club');
    }
}
