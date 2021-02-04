<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $connection = "hos";
    protected $table = "suppliers";
}