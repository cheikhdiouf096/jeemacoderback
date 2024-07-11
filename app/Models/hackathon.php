<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class hackathon extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function users(){
        return $this->belongsTo(User::class);
    }
    public function participant(){
        return $this->hasMany(participant::class);
    }
    public function tag(){
        return $this->hasMany(tag::class);
    }
    public function defis(){
        return $this->hasMany(defis::class);
    }

    // public function Analyse(){
    //     return $this->hasMany(Analyse::class);
    // }
}

