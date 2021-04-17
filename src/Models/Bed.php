<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bed extends Model
{
    protected $table = "beds";

    public function bedType()
    {
        return $this->belongsTo(BedType::class, 'bed_type', 'bed_type_id');
    }
    
    public function ward()
    {
        return $this->belongsTo(Ward::class, 'ward', 'ward_id');
    }
    
    public function regBed()
    {
        return $this->belongsTo(RegBed::class, 'bed_id', 'bed_id');
    }
}