<?php

namespace App\Utils\Mappers\In\Episode;

use App\DTO\In\Episode\GetEpisodesDto;
use Symfony\Component\HttpFoundation\Request;

class GetEpisodesDtoMapper
{
    /**
     * @param Request $request
     * @return GetEpisodesDto
     */
    public static function fromRequest(Request $request): GetEpisodesDto
    {
        return new GetEpisodesDto(
            ids: array_map(fn($id) => (int)$id, $request->query->all('ids')),
            page: $request->query->get('page'),
            limit: $request->query->get('limit'),
            filters: FilterDtoMapper::fromRequest($request),
        );
    }
}