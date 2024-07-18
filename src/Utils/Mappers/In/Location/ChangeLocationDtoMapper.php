<?php

declare(strict_types=1);

namespace App\Utils\Mappers\In\Location;

use App\Contracts\Mappers\In\Location\ChangeLocationDtoMapperInterface;
use App\DTO\In\Location\ChangeLocationDto;
use Symfony\Component\HttpFoundation\Request;

class ChangeLocationDtoMapper implements ChangeLocationDtoMapperInterface
{
    public function fromRequest(Request $request): ChangeLocationDto
    {
        $location = $request->toArray();
        return new ChangeLocationDto(
            id: (int) $request->get('id'),
            name: $location['name'] ?? null,
            type: $location['type'] ?? null,
            dimension: $location['dimension'] ?? null
        );
    }
}