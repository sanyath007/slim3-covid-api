<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{
    protected $table = "room_types";

    public function room()
    {
        return $this->hasMany(Room::class, 'room_type_id', 'room_type');
    }
}