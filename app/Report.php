<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Report extends Model
{
    public $fillable = [
        'transaction_date',
        'zakat',
        'fitrah',
        'fitrah_beras',
        'infak',
        'sedekah',
        'collector_id',
    ];

    public $dates = [
        'transaction_date',
    ];

    public $appends = [
        'total',
    ];

    public function collector()
    {
        return $this->belongsTo(Collector::class);
    }

    public function getTotalAttribute()
    {
        return $this->zakat + $this->fitrah + $this->infak;
    }

    public function scopeWithAmount(Builder $query)
    {
        $query->addSelect(DB::raw("
            SUM(COALESCE(zakat, 0)) +
            SUM(COALESCE(fitrah, 0)) +
            SUM(COALESCE(infak, 0)) +
            SUM(COALESCE(sedekah, 0))
                AS amount
        "));
    }
}
