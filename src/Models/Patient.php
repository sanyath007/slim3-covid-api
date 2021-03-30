<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Capsule\Manager as DB;

class Patient extends Model
{
    use \Awobaz\Compoships\Compoships;

    protected $connection = "hos";
    protected $table = "patient";

    public function address()
    {
        return $this->hasOne(
            PatientAddress::class,
            ['chwpart', 'amppart', 'tmbpart'],
            ['chwpart', 'amppart', 'tmbpart']
        );
    }
}