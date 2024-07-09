<?php

namespace App\Utils\Mappers\In\Episode;

use App\DTO\In\Episode\ChangeEpisodeDto;
use Symfony\Component\HttpFoundation\Request;

class ChangeEpisodeDtoMapper
{
    /**
     * @param Request $request
     * @return ChangeEpisodeDto
     */
    public static function fromRequest(Request $request): ChangeEpisodeDto
    {
        $episode = $request->toArray();
        return new ChangeEpisodeDto(
            id: $request->get('id'),
            name: $episode['name'] ?? null,
            airDate: $episode['airDate'] ?? null,
            code: $episode['code'] ?? null
        );
    }
}