<?php

declare(strict_types=1);

namespace App\DTO\Out\Location;

readonly class ShortLocationDto
{
    public function __construct(
        public string $name,
        public string $url
    )
    {
    }
}