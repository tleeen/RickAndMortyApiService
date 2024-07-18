<?php

declare(strict_types=1);

namespace App\Utils\Mappers\In\Location;

use App\Contracts\Mappers\In\Location\LocationFilterDtoMapperInterface;
use App\DTO\In\Location\LocationFilterDto;
use Symfony\Component\HttpFoundation\Request;

class LocationFilterDtoMapper implements LocationFilterDtoMapperInterface
{
    public function fromRequest(Request $request): LocationFilterDto
    {
        return new LocationFilterDto(
            name: $request->query->get('name') ?? null,
            type: $request->query->get('type') ?? null,
            dimension: $request->query->get('dimension') ?? null
        );
    }
}
