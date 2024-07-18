<?php

declare(strict_types=1);

namespace App\Utils\Mappers\In\Character;

use App\Contracts\Mappers\In\Character\ChangeCharacterDtoMapperInterface;
use App\DTO\In\Character\ChangeCharacterDto;
use Symfony\Component\HttpFoundation\Request;

class ChangeCharacterDtoMapper implements ChangeCharacterDtoMapperInterface
{
    public function fromRequest(Request $request): ChangeCharacterDto
    {
        $character = $request->toArray();
        return new ChangeCharacterDto(
            id: (int) $request->get('id'),
            name: $character['name'] ?? null,
            status: $character['status'] ?? null,
            species: $character['species'] ?? null,
            type: $character['type'] ?? null,
            gender: $character['gender'] ?? null,
            originId: $character['originId'] ?? null,
            locationId: $character['locationId'] ?? null,
            image: $character['image'] ?? null,
        );
    }
}