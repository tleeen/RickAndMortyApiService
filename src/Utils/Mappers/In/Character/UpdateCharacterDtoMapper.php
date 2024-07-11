<?php

namespace App\Utils\Mappers\In\Character;

use App\Contracts\Mappers\In\Character\UpdateCharacterDtoMapperInterface;
use App\DTO\In\Character\UpdateCharacterDto;
use Symfony\Component\HttpFoundation\Request;

class UpdateCharacterDtoMapper implements UpdateCharacterDtoMapperInterface
{
    public function fromRequest(Request $request): UpdateCharacterDto
    {
        $character = $request->toArray();
        return new UpdateCharacterDto(
            id: (int) $request->get('id'),
            name: $character['name'],
            status: $character['status'],
            species: $character['species'],
            type: $character['type'],
            gender: $character['gender'],
            originId: (int) $character['originId'],
            locationId: (int) $character['locationId'],
            image: $character['image'],
        );
    }
}