<?php

namespace App\Utils\Mappers\In\Location;

use App\DTO\In\Location\GetLocationsDto;
use Symfony\Component\HttpFoundation\Request;

class GetLocationsDtoMapper
{
    /**
     * @param Request $request
     * @return GetLocationsDto
     */
    public static function fromRequest(Request $request): GetLocationsDto
    {
        return new GetLocationsDto(
            ids: array_map(fn($id) => (int)$id, $request->query->all('ids')),
            page: $request->query->get('page'),
            limit: $request->query->get('limit'),
            filters: FilterDtoMapper::fromRequest($request),
        );
    }
}