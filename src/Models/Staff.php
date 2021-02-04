<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $connection = "person";
    protected $table = "personal";

    public function booking()
    {
        return $this->hasMany(Booking::class, 'person_id', 'user_id');
    }
}