<?php

namespace App\Utils\Mappers\In\Episode;

use App\DTO\In\Episode\UpdateEpisodeDto;
use Symfony\Component\HttpFoundation\Request;

class UpdateEpisodeDtoMapper
{
    /**
     * @param Request $request
     * @return UpdateEpisodeDto
     */
    public static function fromRequest(Request $request): UpdateEpisodeDto
    {
        $episode = $request->toArray();
        return new UpdateEpisodeDto(
            id: $request->get('id'),
            name: $episode['name'],
            airDate: $episode['airDate'],
            code: $episode['code']
        );
    }
}