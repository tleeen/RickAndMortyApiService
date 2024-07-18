<?php

declare(strict_types=1);

namespace App\Utils\Mappers\In\Episode;

use App\Contracts\Mappers\In\Episode\EpisodeFilterDtoMapperInterface;
use App\DTO\In\Episode\EpisodeFilterDto;
use Symfony\Component\HttpFoundation\Request;

class EpisodeFilterDtoMapper implements EpisodeFilterDtoMapperInterface
{
    public function fromRequest(Request $request): EpisodeFilterDto
    {
        return new EpisodeFilterDto(
            name: $request->query->get('name') ?? null,
            code: $request->query->get('code') ?? null
        );
    }
}