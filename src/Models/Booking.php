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
        return $this->belongsTo(Ward::class, 'ward_id', 'ward');
    }
    
    public function bookedUser()
    {
        return $this->belongsTo(Person::class, 'order_by', 'person_id');
    }
}