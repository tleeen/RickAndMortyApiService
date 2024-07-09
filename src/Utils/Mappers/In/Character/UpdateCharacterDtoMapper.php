<?php

namespace App\Utils\Mappers\In\Character;

use App\DTO\In\Character\UpdateCharacterDto;
use Symfony\Component\HttpFoundation\Request;

class UpdateCharacterDtoMapper
{
    /**
     * @param Request $request
     * @return UpdateCharacterDto
     */
    public static function fromRequest(Request $request): UpdateCharacterDto
    {
        $character = $request->toArray();
        return new UpdateCharacterDto(
            id: $request->get('id'),
            name: $character['name'],
            status: $character['status'],
            species: $character['species'],
            type: $character['type'],
            gender: $character['gender'],
            originId: $character['originId'],
            locationId: $character['locationId'],
            image: $character['image'],
        );
    }
}