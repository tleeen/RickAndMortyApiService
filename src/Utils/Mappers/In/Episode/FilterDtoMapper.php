<?php

namespace App\Utils\Mappers\In\Episode;

use App\DTO\In\Episode\FilterDto;
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
            code: $request->query->get('code') ?? null
        );
    }
}