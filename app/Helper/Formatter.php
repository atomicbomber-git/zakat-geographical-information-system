<?php

namespace App\Helper;

use Illuminate\Support\Carbon;

class Formatter
{
    public static function date($date) {
        return (new Carbon($date))->format("d-m-Y");
    }

    public static function datetime($datetime) {
        return (new Carbon($datetime))->format("d-m-Y H:i:s");
    }

    public static function currency($value)
    {
        return number_format($value, 0, ",", ".");
    }

    public static function gender($value)
    {
        $genders = [
            'l' => 'Laki-Laki',
            'p' => 'Perempuan',
        ];

        return $genders[$value] ?? '-';
    }
}
