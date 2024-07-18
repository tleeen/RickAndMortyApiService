<?php

declare(strict_types=1);

namespace App\Utils\Mappers\In\Episode;

use App\Contracts\Mappers\In\Episode\UpdateEpisodeDtoMapperInterface;
use App\DTO\In\Episode\UpdateEpisodeDto;
use Symfony\Component\HttpFoundation\Request;

class UpdateEpisodeDtoMapper implements UpdateEpisodeDtoMapperInterface
{
    public function fromRequest(Request $request): UpdateEpisodeDto
    {
        $episode = $request->toArray();
        return new UpdateEpisodeDto(
            id: (int) $request->get('id'),
            name: $episode['name'],
            airDate: $episode['air_date'],
            code: $episode['episode'],
            characterIds: $episode['characterIds']
        );
    }
}