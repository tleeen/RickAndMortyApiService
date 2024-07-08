<?php

namespace App\DTO\Utils;

class UrlMaker
{
    public static function makeUnique(string $baseUrl, string $basePrefix, string $modulePrefix, string $id): string
    {
        return $baseUrl . $basePrefix . $modulePrefix . '/' . $id;
    }

    public static function makeStoreImage(string $baseUrl, string $basePrefix, string $modulePrefix, string $image): string
    {
        return $baseUrl . $basePrefix . $modulePrefix . '/avatar/' . $image;
    }

    public static function makePaginatePage(string $baseUrl, string $basePrefix, string $modulePrefix, int $page): string
    {
        return $baseUrl . $basePrefix . $modulePrefix . '/?page=' . $page;
    }
}