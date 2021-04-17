<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ip extends Model
{
    protected $connection = "hos";
    protected $table = "ipt";

    public function hpatient()
    {
        return $this->belongsTo(HPatient::class, 'hn', 'hn');
    }
    
    public function hward()
    {
        return $this->belongsTo(HWard::class, 'ward', 'ward');
    }
    
    public function pttype()
    {
        return $this->belongsTo(Pttype::class, 'pttype', 'pttype');
    }

    public function admdoctor()
    {
        return $this->belongsTo(Doctor::class, 'admdoctor', 'code');
    }
}