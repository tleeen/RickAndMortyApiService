<?php

declare(strict_types=1);

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
            originId: $character['originId'],
            locationId: $character['locationId'],
            image: $character['image'],
        );
    }
}
