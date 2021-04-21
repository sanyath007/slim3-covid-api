<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HIp extends Model
{
    protected $connection = "hos";
    protected $table = "ipt";

    public function hpatient()
    {
        return $this->belongsTo(HPatient::class, 'hn', 'hn');
    }
    
    public function hanstat()
    {
        return $this->belongsTo(HAnStat::class, 'an', 'an');
    }
    
    public function hward()
    {
        return $this->belongsTo(HWard::class, 'ward', 'ward');
    }
    
    public function hpttype()
    {
        return $this->belongsTo(HPttype::class, 'pttype', 'pttype');
    }

    public function hadmdoctor()
    {
        return $this->belongsTo(HDoctor::class, 'admdoctor', 'code');
    }
    
    public function regis()
    {
        return $this->setConnection('default')->belongsTo(Registration::class, 'an', 'an');
    }
}