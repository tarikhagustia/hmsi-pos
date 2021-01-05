<?php


namespace App\Libraries;


class Currency
{
    public static function format($amount)
    {
        return "Rp. ".number_format($amount);
    }
}
