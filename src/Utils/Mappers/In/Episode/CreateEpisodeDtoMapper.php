<?php

declare(strict_types=1);

namespace App\Utils\Mappers\In\Episode;

use App\Contracts\Mappers\In\Episode\CreateEpisodeDtoMapperInterface;
use App\DTO\In\Episode\CreateEpisodeDto;
use Symfony\Component\HttpFoundation\Request;

class CreateEpisodeDtoMapper implements CreateEpisodeDtoMapperInterface
{
    public function fromRequest(Request $request): CreateEpisodeDto
    {
        $episode = $request->toArray();

        return new CreateEpisodeDto(
            name: $episode['name'],
            airDate: $episode['air_date'],
            code: $episode['episode'],
            characterIds: $episode['characterIds'],
        );
    }
}
