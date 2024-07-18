<?php

declare(strict_types=1);

namespace App\Utils\Mappers\In\Episode;

use App\Contracts\Mappers\In\Episode\ChangeEpisodeDtoMapperInterface;
use App\DTO\In\Episode\ChangeEpisodeDto;
use Symfony\Component\HttpFoundation\Request;

class ChangeEpisodeDtoMapper implements ChangeEpisodeDtoMapperInterface
{
    public function fromRequest(Request $request): ChangeEpisodeDto
    {
        $episode = $request->toArray();
        return new ChangeEpisodeDto(
            id: (int) $request->get('id'),
            name: $episode['name'] ?? null,
            airDate: $episode['air_date'] ?? null,
            code: $episode['episode'] ?? null,
            characterIds: $episode['characterIds'] ?? null
        );
    }
}