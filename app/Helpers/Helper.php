<?php
namespace App\Helpers;

use Carbon\Carbon;
use Akaunting\Money\Currency;
use Akaunting\Money\Money;

class Helper
{
    public static function amountFormat($amount)
    {
        return Money::PHP($amount, true);
    }

    public static function showDateTime($date_finish)
    {
        return Carbon::parse($date_finish)->format('M d Y h:mA');
    }

    public static function upCase($case)
    {
        return strtoupper($case);
    }
}