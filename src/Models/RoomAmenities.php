<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomAmenities extends Model
{
    protected $table = "room_amenities";

    public function room()
    {
        return $this->hasMany(Room::class, 'room_id', 'room_id');
    }

    public function amenity()
    {
        return $this->hasMany(Amenity::class, 'amenity_id', 'amenity_id');
    }
}