<?php

namespace App\Contracts\Mappers\In\Episode;

use App\DTO\In\Episode\EpisodeFilterDto;
use Symfony\Component\HttpFoundation\Request;

interface EpisodeFilterDtoMapperInterface
{
    public function fromRequest(Request $request): EpisodeFilterDto;
}