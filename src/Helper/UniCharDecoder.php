<?php

declare(strict_types=1);


namespace App\Helper;


final class UniCharDecoder
{
    public static function decode($value = null)
    {
        if(!isset($value)) {
            return null;
        }
        return json_decode("\"$value\"");
    }
}