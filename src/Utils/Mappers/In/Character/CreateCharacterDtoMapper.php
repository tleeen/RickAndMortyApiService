<?php

namespace App\Utils\Mappers\In\Character;

use App\DTO\In\Character\CreateCharacterDto;
use Symfony\Component\HttpFoundation\Request;

class CreateCharacterDtoMapper
{
    /**
     * @param Request $request
     * @return CreateCharacterDto
     */
    public static function fromRequest(Request $request): CreateCharacterDto
    {
        $character = $request->toArray();
        return new CreateCharacterDto(
            name: $character['name'],
            status: $character['status'],
            species: $character['species'],
            type: $character['type'] ?? null,
            gender: $character['gender'],
            originId: $character['originId'],
            locationId: $character['locationId'],
            image: $character['image'],
        );
    }
}