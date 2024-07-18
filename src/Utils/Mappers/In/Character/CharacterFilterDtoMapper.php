<?php

declare(strict_types=1);

namespace App\Utils\Mappers\In\Character;

use App\Contracts\Mappers\In\Character\CharacterFilterDtoMapperInterface;
use App\DTO\In\Character\CharacterFilterDto;
use Symfony\Component\HttpFoundation\Request;

class CharacterFilterDtoMapper implements CharacterFilterDtoMapperInterface
{
    public function fromRequest(Request $request): CharacterFilterDto
    {
        return new CharacterFilterDto(
            name: $request->query->get('name') ?? null,
            status: $request->query->get('status') ?? null,
            species: $request->query->get('species') ?? null,
            type: $request->query->get('type') ?? null,
            gender: $request->query->get('gender') ?? null,
        );
    }
}