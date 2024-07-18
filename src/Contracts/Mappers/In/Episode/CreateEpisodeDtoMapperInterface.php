<?php

declare(strict_types=1);

namespace App\Contracts\Mappers\In\Episode;

use App\DTO\In\Episode\CreateEpisodeDto;
use Symfony\Component\HttpFoundation\Request;

interface CreateEpisodeDtoMapperInterface
{
    public function fromRequest(Request $request): CreateEpisodeDto;
}
