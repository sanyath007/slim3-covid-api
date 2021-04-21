<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HPatientAddress extends Model
{
    use \Awobaz\Compoships\Compoships;
    
    protected $connection = "hos";
    protected $table = "thaiaddress";
}