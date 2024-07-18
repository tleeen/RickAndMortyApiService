<?php

declare(strict_types=1);

namespace App\DTO\Out\Episode;

readonly class EpisodeDto
{
    public function __construct(
        public int $id,
        public string $name,
        public string $air_date,
        public string $episode,
        public array $characters,
        public string $url,
        public string $created,
    ) {
    }
}
