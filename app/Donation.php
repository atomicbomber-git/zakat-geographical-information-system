<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    public const GENDERS = [
        'l' => 'Laki-Laki',
        'p' => 'Perempuan'
    ];

    public $dates = [
        'transaction_date'
    ];

    protected $casts = [
        'transaction_date' => 'date:Y-m-d',
    ];

    public $fillable = [
        'transaction_date', 'name', 'nik', 'address', 'kecamatan', 'kelurahan',
        'phone', 'gender', 'occupation', 'ansaf', 'help_program',
        'amount', 'latitude', 'longitude', 'collector_id'
    ];

    public function getGenderAttribute($value)
    {
        return $this::GENDERS[$value];
    }
}
