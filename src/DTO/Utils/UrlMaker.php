<?php

namespace App\DTO\Utils;

class UrlMaker
{
    public static function makeUnique(string $baseUrl, string $basePrefix, string $modulePrefix, string $id): string
    {
        return $baseUrl . $basePrefix . $modulePrefix . '/' . $id;
    }
}