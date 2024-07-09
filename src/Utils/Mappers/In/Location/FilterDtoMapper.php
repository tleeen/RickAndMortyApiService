<?php

namespace App\Utils\Mappers\In\Location;

use App\DTO\In\Location\FilterDto;
use Symfony\Component\HttpFoundation\Request;

class FilterDtoMapper
{
    /**
     * @param Request $request
     * @return FilterDto
     */
    public static function fromRequest(Request $request): FilterDto
    {
        return new FilterDto(
            name: $request->query->get('name') ?? null,
            type: $request->query->get('type') ?? null,
            dimension: $request->query->get('dimension') ?? null
        );
    }
}