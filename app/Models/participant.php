<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class participant extends Model
{
    use HasFactory;
    protected $guarder=[];

   public function individuel(){
      return $this->belongsTo(individuel::class);
   }
   public function equipe(){
      return $this->belongsTo(equipe::class);
}
    public function hackathon(){
        return $this->belongsTo(hackathon::class);
    }

    public function Soumissions(){
        return $this->hasMany(Soumissions::class);
    }

}

