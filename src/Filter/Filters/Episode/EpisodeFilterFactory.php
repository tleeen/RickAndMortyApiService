<?php

declare(strict_types=1);

namespace App\Filter\Filters\Episode;

use App\DTO\In\Episode\EpisodeFilterDto;

class EpisodeFilterFactory
{
    public static function create(EpisodeFilterDto $filters): EpisodeFilter
    {
        return new EpisodeFilter($filters);
    }
}