<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
}
