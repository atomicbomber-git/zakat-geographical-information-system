<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Collector extends Model
{
    public $fillable = [
        'name', 'address', 'latitude', 'longitude'
    ];
}
