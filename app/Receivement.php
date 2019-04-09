<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Receivement extends Model
{
    public const GENDERS = [
        'l' => 'Laki-Laki',
        'p' => 'Perempuan'
    ];

    public $dates = [
        "transaction_date"
    ];

    public $fillable = [
        "transaction_date","collector_id","name",
        "NIK","kecamatan","kelurahan",
        "phone", "gender","npwz",
        "zakat","fitrah","infak",
        "muzakki_id"
    ];

    public function collector()
    {
        return $this->belongsTo(Collector::class);
    }

    public function getGenderAttribute($value)
    {
        return $this::GENDERS[$value];
    }
}
