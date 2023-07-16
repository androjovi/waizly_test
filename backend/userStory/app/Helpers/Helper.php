<?php

namespace App\Helpers;

class Helper
{
    static function formattedCurrency($value, $lang = 'id')
    {
        return sprintf("Rp %s", number_format($value, 0, ',', '.'));
    }
}