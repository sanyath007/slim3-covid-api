<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HPatient extends Model
{
    use \Awobaz\Compoships\Compoships;
    
    protected $connection = "hos";
    protected $table = "patient";
    
    public function haddress()
    {
        return $this->hasOne(
            HPatientAddress::class,
            ['chwpart', 'amppart', 'tmbpart'],
            ['chwpart', 'amppart', 'tmbpart']
        );
    }
}