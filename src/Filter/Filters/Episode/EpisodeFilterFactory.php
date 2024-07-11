<?php

namespace App\Filter\Filters\Episode;

use App\DTO\In\Episode\EpisodeFilterDto;

class EpisodeFilterFactory
{
    public static function create(EpisodeFilterDto $filters): EpisodeFilter
    {
        return new EpisodeFilter($filters);
    }
}