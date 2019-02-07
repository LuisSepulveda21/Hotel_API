<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'Hotel_ID', 'State','User_ID', 'StartDate', 'EndDate', 'NroRooms'
    ];

    public $timestamps = false;
}
