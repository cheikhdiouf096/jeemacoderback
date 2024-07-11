<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class individuel extends Model
{
    use HasFactory;
    protected $guarder=[];
    public function participant(){
        return $this->belongsTo(participant::class);
    }
}
