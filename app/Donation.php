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
        'phone', 'gender', 'occupation', 'asnaf', 'help_program',
        'amount', 'latitude', 'longitude', 'collector_id', "mustahiq_id",
    ];

    public function mustahiq()
    {
        return $this->belongsTo(Mustahiq::class);
    }

    public function getGenderAttribute($value)
    {
        return $this::GENDERS[$value];
    }
}
