<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donors extends Model
{
    use HasFactory;
    public function subscribes(){
        return $this->hasMany(Subscribes::class, "donor_id");
   }
}
