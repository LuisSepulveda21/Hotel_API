<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Keysapi extends Model
{
     protected $fillable = [
        'contact',
        'company',
        'email',
        'key',
    ];

   public $timestamps = false;
}
