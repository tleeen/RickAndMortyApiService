<?php

declare(strict_types=1);

namespace App\DTO\Out\Character;

use App\DTO\Out\Location\ShortLocationDto;

readonly class CharacterDto
{
    public function __construct(
        public int $id,
        public string $name,
        public string $status,
        public string $species,
        public string $type,
        public string $gender,
        public ShortLocationDto $origin,
        public ShortLocationDto $location,
        public string $image,
        public array $episode,
        public string $url,
        public string $created
    ) {
    }
}
