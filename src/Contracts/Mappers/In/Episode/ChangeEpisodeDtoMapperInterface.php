<?php

declare(strict_types=1);

namespace App\Contracts\Mappers\In\Episode;

use App\DTO\In\Episode\ChangeEpisodeDto;
use Symfony\Component\HttpFoundation\Request;

interface ChangeEpisodeDtoMapperInterface
{
    public function fromRequest(Request $request): ChangeEpisodeDto;
}
