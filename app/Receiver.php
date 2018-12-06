<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Receiver extends Model
{
    public $fillable = [
        "name", "nik", "address", "kecamatan", "kelurahan",
        "phone", "sex", "occupation", "ansaf", "help_program",
        "amount", "latitude", "longitude",
    ];
}
