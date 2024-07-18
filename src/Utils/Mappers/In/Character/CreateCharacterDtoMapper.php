<?php

namespace App\Utils\Mappers\In\Character;

use App\Contracts\Mappers\In\Character\CreateCharacterDtoMapperInterface;
use App\DTO\In\Character\CreateCharacterDto;
use Symfony\Component\HttpFoundation\Request;

class CreateCharacterDtoMapper implements CreateCharacterDtoMapperInterface
{
    public function fromRequest(Request $request): CreateCharacterDto
    {
        $character = $request->toArray();
        return new CreateCharacterDto(
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