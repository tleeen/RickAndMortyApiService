<?php

namespace App\DTO\Out\Location;

readonly class ShortLocationDto
{
    public string $name;
    public string $url;


    public function __construct(
        string $name,
        string $url
    )
    {
        $this->name = $name;
        $this->url = $url;
    }
}