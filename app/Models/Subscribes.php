<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscribes extends Model
{
    use HasFactory;

    public function donors(){
        return $this->belongsTo(Donors::class, 'donor_id');// second and third arguments are unnecessary.

    }
}
