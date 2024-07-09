<?php

namespace App\Utils\Mappers\In\Location;

use App\DTO\In\Location\ChangeLocationDto;
use Symfony\Component\HttpFoundation\Request;

class ChangeLocationDtoMapper
{
    /**
     * @param Request $request
     * @return ChangeLocationDto
     */
    public static function fromRequest(Request $request): ChangeLocationDto
    {
        $location = $request->toArray();
        return new ChangeLocationDto(
            id: $request->get('id'),
            name: $location['name'] ?? null,
            type: $location['type'] ?? null,
            dimension: $location['dimension'] ?? null
        );
    }
}