<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    public $fillable = [
        'transaction_date', 'zakat', 'fitrah', 'infak', 'collector_id', 'note'
    ];

    public function collector()
    {
        return $this->belongsTo(Collector::class);
    }
}
