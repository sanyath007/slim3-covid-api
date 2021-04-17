<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use \Awobaz\Compoships\Compoships;

    protected $table = "patients";
}