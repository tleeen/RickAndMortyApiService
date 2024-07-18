<?php

declare(strict_types=1);

namespace App\Contracts\Mappers\In\Episode;

use App\DTO\In\Episode\GetEpisodesDto;
use Symfony\Component\HttpFoundation\Request;

interface GetEpisodesDtoMapperInterface
{
    public function fromRequest(Request $request): GetEpisodesDto;
}
