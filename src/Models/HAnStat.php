<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HAnStat extends Model
{
    protected $connection = "hos";
    protected $table = "an_stat";

    public function hip()
    {
        return $this->hasOne(HIp::class, 'an', 'an');
    }
}