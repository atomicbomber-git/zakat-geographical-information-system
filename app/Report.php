<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    public $fillable = [
        'transaction_date', 'npwz', 'amount', 'type', 'collector_id', 'note'
    ];
}
