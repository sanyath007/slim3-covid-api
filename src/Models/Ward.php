<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{
    protected $table = "wards";

    protected $primaryKey = 'ward_id';

    public function beds()
    {
        return $this->hasMany(Bed::class, 'ward', 'ward_id');
    }
    
    public function building()
    {
        return $this->belongsTo(Building::class, 'building', 'id');
    }

    public function regises()
    {
        return $this->hasMany(Registration::class, 'ward', 'ward_id');
    }
}