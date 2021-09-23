<?php


namespace App\Service\loginService;


class validators
{
    public static function isNotBlank($text): bool
    {
        return strlen(trim($text)) > 0;
    }
}
