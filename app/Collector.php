<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Collector extends Model
{
    public $fillable = [
        'name', 'address', 'latitude', 'longitude', 'user_id', 'npwz'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
