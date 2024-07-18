<?php

declare(strict_types=1);

namespace App\Utils\Mappers\In\Location;

use App\Contracts\Mappers\In\Location\CreateLocationDtoMapperInterface;
use App\DTO\In\Location\CreateLocationDto;
use Symfony\Component\HttpFoundation\Request;

class CreateLocationDtoMapper implements CreateLocationDtoMapperInterface
{
    public function fromRequest(Request $request): CreateLocationDto
    {
        $location = $request->toArray();
        return new CreateLocationDto(
            name: $location['name'],
            type: $location['type'],
            dimension: $location['dimension']
        );
    }
}