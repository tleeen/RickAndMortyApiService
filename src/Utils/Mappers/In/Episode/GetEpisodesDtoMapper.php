<?php

declare(strict_types=1);

namespace App\Utils\Mappers\In\Episode;

use App\Contracts\Mappers\In\Episode\EpisodeFilterDtoMapperInterface;
use App\Contracts\Mappers\In\Episode\GetEpisodesDtoMapperInterface;
use App\DTO\In\Episode\GetEpisodesDto;
use Symfony\Component\HttpFoundation\Request;

class GetEpisodesDtoMapper implements GetEpisodesDtoMapperInterface
{
    public function __construct(
        private readonly EpisodeFilterDtoMapperInterface $filterDtoMapper,
    )
    {
    }

    public function fromRequest(Request $request): GetEpisodesDto
    {
        return new GetEpisodesDto(
            ids: array_map(fn($id) => (int) $id, $request->query->all('ids')) ?: null,
            page: (int) $request->query->get('page') ?: null,
            limit: (int) $request->query->get('limit') ?: null,
            filters: $this->filterDtoMapper->fromRequest($request),
        );
    }
}