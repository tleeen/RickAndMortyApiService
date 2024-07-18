<?php

declare(strict_types=1);

namespace App\Filter\Filters\Character;

use App\DTO\In\Character\CharacterFilterDto;

class CharacterFilterFactory
{
    public static function create(CharacterFilterDto $filters): CharacterFilter
    {
        return new CharacterFilter($filters);
    }
}
