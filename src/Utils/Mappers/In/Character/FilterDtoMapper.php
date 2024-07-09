<?php

namespace App\Utils\Mappers\In\Character;

use App\DTO\In\Character\FilterDto;
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
            status: $request->query->get('status') ?? null,
            species: $request->query->get('species') ?? null,
            type: $request->query->get('type') ?? null,
            gender: $request->query->get('gender') ?? null,
        );
    }
}