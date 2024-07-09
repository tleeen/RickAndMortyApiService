<?php

namespace App\Utils\Mappers\In\Location;

use App\DTO\In\Location\UpdateLocationDto;
use Symfony\Component\HttpFoundation\Request;

class UpdateLocationDtoMapper
{
    /**
     * @param Request $request
     * @return UpdateLocationDto
     */
    public static function fromRequest(Request $request): UpdateLocationDto
    {
        $location = $request->toArray();
        return new UpdateLocationDto(
            id: $request->get('id'),
            name: $location['name'],
            type: $location['type'],
            dimension: $location['dimension']
        );
    }
}