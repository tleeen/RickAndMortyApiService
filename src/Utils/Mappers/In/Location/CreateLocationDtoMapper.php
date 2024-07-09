<?php

namespace App\Utils\Mappers\In\Location;

use App\DTO\In\Location\CreateLocationDto;
use Symfony\Component\HttpFoundation\Request;

class CreateLocationDtoMapper
{
    /**
     * @param Request $request
     * @return CreateLocationDto
     */
    public static function fromRequest(Request $request): CreateLocationDto
    {
        $location = $request->toArray();
        return new CreateLocationDto(
            name: $location['name'],
            type: $location['type'],
            dimension: $location['dimension']
        );
    }
}