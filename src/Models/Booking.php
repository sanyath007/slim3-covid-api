<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $table = "bookings";

    public function room()
    {
        return $this->hasMany(BookingRoom::class, 'book_id', 'book_id');
    }

    public function ward()
    {
        return $this->belongsTo(Ward::class, 'ward', 'ward');
    }
    
    public function an()
    {
        return $this->belongsTo(Ip::class, 'an', 'an');
    }
    
    public function user()
    {
        return $this->belongsTo(Staff::class, 'user', 'person_id');
    }
}