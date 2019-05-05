<?php

namespace App\Helper;

use Illuminate\Support\Carbon;

class Formatter
{
    public static function date($date) {
        return (new Carbon($date))->format("d-m-Y");
    }

    public static function currency($value)
    {
        return number_format($value, 0, ",", ".");
    }
}
