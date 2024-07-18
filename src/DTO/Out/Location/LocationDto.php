<?php

declare(strict_types=1);

namespace App\DTO\Out\Location;

readonly class LocationDto
{
    public function __construct(
        public int $id,
        public string $name,
        public string $type,
        public string $dimension,
        public array $residents,
        public string $url,
        public string $created,
    ) {
    }
}
