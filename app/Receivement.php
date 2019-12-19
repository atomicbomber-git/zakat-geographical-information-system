<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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
        "transaction_date",
        "collector_id",
        "name",
        "NIK",
        "kecamatan",
        "kelurahan",
        "phone",
        "gender",
        "npwz",
        "zakat", // Zakat mal
        "fitrah", // Zakat fitrah (rupiah)
        "fitrah_beras", // Zakat fitrah (beras)
        "infak", // Infak
        "sedekah", // Sedekah
        "muzakki_id"
    ];

    public function collector()
    {
        return $this->belongsTo(Collector::class);
    }

    public function muzakki()
    {
        return $this->belongsTo(Muzakki::class);
    }

    public function getGenderAttribute($value)
    {
        return $this::GENDERS[$value];
    }

    public function scopeWithAmount(Builder $query, string $as = "amount")
    {
        $query->addSelect(DB::raw("(
            COALESCE(zakat, 0) +
            COALESCE(fitrah, 0) +
            COALESCE(infak, 0) +
            COALESCE(sedekah, 0)
        ) AS $as"));
    }
}
