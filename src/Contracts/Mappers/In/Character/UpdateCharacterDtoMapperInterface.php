<?php

declare(strict_types=1);

namespace App\Contracts\Mappers\In\Character;

use App\DTO\In\Character\UpdateCharacterDto;
use Symfony\Component\HttpFoundation\Request;

interface UpdateCharacterDtoMapperInterface
{
    public function fromRequest(Request $request): UpdateCharacterDto;
}