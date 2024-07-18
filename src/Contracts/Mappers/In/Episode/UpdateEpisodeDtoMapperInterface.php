<?php

declare(strict_types=1);

namespace App\Contracts\Mappers\In\Episode;

use App\DTO\In\Episode\UpdateEpisodeDto;
use Symfony\Component\HttpFoundation\Request;

interface UpdateEpisodeDtoMapperInterface
{
    public function fromRequest(Request $request): UpdateEpisodeDto;
}
