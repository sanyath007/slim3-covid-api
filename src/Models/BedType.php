<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BedType extends Model
{
    protected $table = "bed_types";

    public function bed()
    {
        return $this->hasMany(Bed::class, 'bed_type_id', 'bed_type');
    }
}