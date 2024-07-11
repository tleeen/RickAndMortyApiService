<?php

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
            airDate: $episode['airDate'] ?? null,
            code: $episode['code'] ?? null,
            characterIds: $episode['characterIds'] ?? null
        );
    }
}