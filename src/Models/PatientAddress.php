<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientAddress extends Model
{
    use \Awobaz\Compoships\Compoships;
    
    protected $connection = "hos";
    protected $table = "thaiaddress";
}