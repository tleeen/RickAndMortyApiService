<?php

namespace App\DTO\Out\Location;

class ShortLocationDto
{
    public readonly string $name;
    public readonly string $url;


    public function __construct(
        string $name,
        string $url
    )
    {
        $this->name = $name;
        $this->url = $url;
    }
}