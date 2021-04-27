<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{
    protected $table = "wards";

    protected $primaryKey = 'ward_id';

    public function bed()
    {
        return $this->hasMany(Bed::class, 'ward', 'ward_id');
    }
}