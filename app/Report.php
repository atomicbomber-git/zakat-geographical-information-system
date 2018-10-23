<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    const TYPES = [
        'ZAKAT' => 'Zakat',
        'FITRAH' => 'Fitrah',
        'INFAK' => 'Infak'
    ];

    public $fillable = [
        'transaction_date', 'amount', 'type', 'collector_id', 'note'
    ];
}
