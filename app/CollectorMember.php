<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CollectorMember extends Model
{
    public $fillable = [
        "collector_id",
        "name",
        "position",
    ];
}
