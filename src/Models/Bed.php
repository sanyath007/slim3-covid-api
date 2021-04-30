<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bed extends Model
{
    protected $table = "beds";
    
    protected $primaryKey = 'bed_id';

    public function bedType()
    {
        return $this->belongsTo(BedType::class, 'bed_type', 'bed_type_id');
    }
    
    public function ward()
    {
        return $this->belongsTo(Ward::class, 'ward', 'ward_id');
    }
    
    public function regis()
    {
        return $this->hasOne(Registration::class, 'bed', 'bed_id');
    }
}