<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HWard extends Model
{
    protected $connection = "hos";
    protected $table = "ward";

    public function ip()
    {
        return $this->hasMany(Ip::class, 'ward', 'ward');
    }
}