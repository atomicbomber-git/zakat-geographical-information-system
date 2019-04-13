<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mustahiq extends Model
{
    public const GENDERS = [
        'l' => 'Laki-Laki',
        'p' => 'Perempuan'
    ];

    public $fillable = [
        "latitude",
        "longitude",
        "name",
        "nik",
        "age",
        "address",
        "kecamatan",
        "kelurahan",
        "phone",
        "gender",
        "occupation",
        "asnaf",
        "help_program",
        "collector_id",
    ];

    public function collector()
    {
        return $this->belongsTo(Collector::class);
    }

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }
}
