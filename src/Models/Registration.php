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
}