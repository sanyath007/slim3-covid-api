<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{
    protected $connection = "hos";
    protected $table = "ward";

    public function booking()
    {
        return $this->hasMany(Booking::class, 'ward', 'ward_id');
    }
}