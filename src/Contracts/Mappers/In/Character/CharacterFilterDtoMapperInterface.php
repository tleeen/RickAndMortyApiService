<?php

declare(strict_types=1);

namespace App\Contracts\Mappers\In\Character;

use App\DTO\In\Character\CharacterFilterDto;
use Symfony\Component\HttpFoundation\Request;

interface CharacterFilterDtoMapperInterface
{
    public function fromRequest(Request $request): CharacterFilterDto;
}