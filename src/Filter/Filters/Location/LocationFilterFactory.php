<?php

namespace App\Filter\Filters\Location;

use App\DTO\In\Location\LocationFilterDto;

class LocationFilterFactory
{
    public static function create(LocationFilterDto $filters): LocationFilter
    {
        return new LocationFilter($filters);
    }
}