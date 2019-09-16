<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mustahiq extends Model
{
    public const GENDERS = [
        'l' => 'Laki-Laki',
        'p' => 'Perempuan'
    ];

    const ASNAFS = [
        "Fakir",
        "Miskin",
        "Amil",
        "Muallaf",
        "Riqab (Hamba Sahaya)",
        "Ghorim",
        "Sabilillah",
        "Ibnu Sabil",
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
        "nomor_kk",
        "collector_id",
        "description",
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
