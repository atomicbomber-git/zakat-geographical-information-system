<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mustahiq extends Model
{
    const PROGRAM_BANTUAN_KEMANUSIAAN = "Kemanusiaan";
    const PROGRAM_BANTUAN_KESEHATAN = "Kesehatan";
    const PROGRAM_BANTUAN_PENDIDIKAN = "Pendidikan";
    const PROGRAM_BANTUAN_EKONOMI = "Ekonomi";
    const PROGRAM_BANTUAN_DAKWAH = "Dakwah";
    const PROGRAM_BANTUAN_ADVOKASI = "Advokasi";

    public const PROGRAM_BANTUAN_TYPES = [
        self::PROGRAM_BANTUAN_KEMANUSIAAN,
        self::PROGRAM_BANTUAN_KESEHATAN,
        self::PROGRAM_BANTUAN_PENDIDIKAN,
        self::PROGRAM_BANTUAN_EKONOMI,
        self::PROGRAM_BANTUAN_DAKWAH,
        self::PROGRAM_BANTUAN_ADVOKASI,
    ];

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

    public $guarded = [
    ];

    public function collector()
    {
        return $this->belongsTo(Collector::class);
    }

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }

    public function receivements()
    {
        return $this->hasMany(Receivement::class);
    }
}
