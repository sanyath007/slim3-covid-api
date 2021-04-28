<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    protected $table = "registrations";

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'hn', 'hn');
    }

    public function bed()
    {
        return $this->belongsTo(Bed::class, 'bed', 'bed_id');
    }
    
    public function ip()
    {
        return $this->setConnection('hos')->hasOne(Ip::class, 'an', 'an');
    }

    public function ward()
    {
        return $this->belongsTo(Ward::class, 'ward', 'ward_id');
    }
}