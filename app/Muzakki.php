<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Muzakki extends Model
{
    public const GENDERS = [
        'l' => 'Laki-Laki',
        'p' => 'Perempuan'
    ];

    public $fillable = [
        "name", "nik", "address", "kecamatan", "kelurahan",
        "phone", "gender", "npwz", "infak", "latitude",
        "longitude", "collector_id"
    ];

    public function collector()
    {
        return $this->belongsTo(Collector::class);
    }

    public function receivements()
    {
        return $this->hasMany(Receivement::class);
    }
}
