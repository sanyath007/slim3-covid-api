<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $table = "rooms";

    public function roomType()
    {
        return $this->belongsTo(RoomType::class, 'room_type', 'room_type_id');
    }
    
    public function roomGroup()
    {
        return $this->belongsTo(RoomGroup::class, 'room_group', 'room_group_id');
    }
    
    public function building()
    {
        return $this->belongsTo(Building::class, 'building_id', 'building_id');
    }
}