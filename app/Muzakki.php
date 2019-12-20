<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Muzakki extends Model
{
    public const GENDERS = [
        'l' => 'Laki-Laki',
        'p' => 'Perempuan'
    ];

    public $guarded = [
    ];

    public function collector()
    {
        return $this->belongsTo(Collector::class);
    }

    public function receivements()
    {
        return $this->hasMany(Receivement::class);
    }

    public function scopeWithReceivementLastTransactionDate(Builder $query)
    {
        $query->addSelect([
            "receivements_last_transaction_date" => Receivement::query()
                ->whereColumn(
                    (new Muzakki)->getTable() . ".id",
                    (new Receivement)->getTable() . ".muzakki_id"
                )
                ->select("transaction_date")
                ->orderByDesc("transaction_date")
                ->limit(1)
        ]);
    }
    public function scopeWithReceivementAmountSum(Builder $query)
    {
        $query->addSelect([
            "receivements_amount_sum" => Receivement::query()
                ->whereColumn(
                    (new Muzakki)->getTable() . ".id",
                    (new Receivement)->getTable() . ".muzakki_id"
                )
                ->withAmountSum()
                ->limit(1)
        ]);
    }
}
