<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{
    protected $table = "wards";

    public function bed()
    {
        return $this->hasMany(Bed::class, 'ward', 'ward_id');
    }
}