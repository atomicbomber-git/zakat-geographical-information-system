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
        "zakat","fitrah","infak"
    ];

    public function getGenderAttribute($value)
    {
        return $this::GENDERS[$value];
    }
}
