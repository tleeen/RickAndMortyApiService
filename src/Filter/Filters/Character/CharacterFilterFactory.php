<?php

namespace App\Filter\Filters\Character;

use App\DTO\In\Character\FilterDto;

class CharacterFilterFactory
{
    public static function create(FilterDto $filters): CharacterFilter
    {
        return new CharacterFilter($filters);
    }
}