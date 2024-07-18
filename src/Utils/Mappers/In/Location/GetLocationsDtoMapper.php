<?php

namespace App\Utils\Mappers\In\Location;

use App\Contracts\Mappers\In\Location\GetLocationsDtoMapperInterface;
use App\Contracts\Mappers\In\Location\LocationFilterDtoMapperInterface;
use App\DTO\In\Location\GetLocationsDto;
use Symfony\Component\HttpFoundation\Request;

class GetLocationsDtoMapper implements GetLocationsDtoMapperInterface
{
    public function __construct(
        private readonly LocationFilterDtoMapperInterface $filterDtoMapper,
    )
    {
    }

    public function fromRequest(Request $request): GetLocationsDto
    {
        return new GetLocationsDto(
            ids: array_map(fn($id) => (int) $id, $request->query->all('ids')) ?: null,
            page: (int) $request->query->get('page') ?: null,
            limit: (int) $request->query->get('limit') ?: null,
            filters: $this->filterDtoMapper->fromRequest($request),
        );
    }
}