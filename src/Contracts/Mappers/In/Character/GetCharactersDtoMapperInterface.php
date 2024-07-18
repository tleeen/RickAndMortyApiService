<?php

declare(strict_types=1);

namespace App\Contracts\Mappers\In\Character;

use App\DTO\In\Character\GetCharactersDto;
use Symfony\Component\HttpFoundation\Request;

interface GetCharactersDtoMapperInterface
{
    public function fromRequest(Request $request): GetCharactersDto;
}
