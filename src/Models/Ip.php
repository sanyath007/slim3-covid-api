<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ip extends Model
{
    protected $connection = "hos";
    protected $table = "ipt";

    public function booking()
    {
        return $this->hasMany(Booking::class, 'an', 'an');
    }
}