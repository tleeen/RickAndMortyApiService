<?php

namespace App\Filter\Filters\Location;

use App\DTO\In\Location\FilterDto;

class LocationFilterFactory
{
    public static function create(FilterDto $filters): LocationFilter
    {
        return new LocationFilter($filters);
    }
}