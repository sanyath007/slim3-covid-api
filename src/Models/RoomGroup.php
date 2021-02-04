<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomGroup extends Model
{
    protected $table = "room_groups";

    public function room()
    {
        return $this->hasMany(Room::class, 'room_group_id', 'room_group');
    }
}