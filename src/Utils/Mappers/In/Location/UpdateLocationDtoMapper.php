<?php

declare(strict_types=1);

namespace App\Utils\Mappers\In\Location;

use App\Contracts\Mappers\In\Location\UpdateLocationDtoMapperInterface;
use App\DTO\In\Location\UpdateLocationDto;
use Symfony\Component\HttpFoundation\Request;

class UpdateLocationDtoMapper implements UpdateLocationDtoMapperInterface
{
    public function fromRequest(Request $request): UpdateLocationDto
    {
        $location = $request->toArray();

        return new UpdateLocationDto(
            id: (int) $request->get('id'),
            name: $location['name'],
            type: $location['type'],
            dimension: $location['dimension']
        );
    }
}
