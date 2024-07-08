<?php

namespace App\Filter\Filters\Episode;

use App\DTO\In\Episode\FilterDto;

class EpisodeFilterFactory
{
    public static function create(FilterDto $filters): EpisodeFilter
    {
        return new EpisodeFilter($filters);
    }
}