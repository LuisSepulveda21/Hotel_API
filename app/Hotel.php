<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    protected $fillable = [
        'name',
        'state',
        'address',
        'type',
        'size',
        'phone',
        'fax',
        'rooms',
        'email',
        'website',
        'latitude',
        'longitude',
    ];

 
public $timestamps = false;
}
