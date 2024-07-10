<?php

namespace App\Utils\Mappers\In\Episode;

use App\DTO\In\Episode\CreateEpisodeDto;
use Symfony\Component\HttpFoundation\Request;

class CreateEpisodeDtoMapper
{
    /**
     * @param Request $request
     * @return CreateEpisodeDto
     */
    public static function fromRequest(Request $request): CreateEpisodeDto
    {
        $episode = $request->toArray();
        return new CreateEpisodeDto(
            name: $episode['name'],
            airDate: $episode['airDate'],
            code: $episode['code'],
            characterIds: $episode['characterIds'],
        );
    }
}