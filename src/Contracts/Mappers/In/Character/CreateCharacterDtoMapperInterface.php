<?php

namespace App\Contracts\Mappers\In\Character;

use App\DTO\In\Character\CreateCharacterDto;
use Symfony\Component\HttpFoundation\Request;

interface CreateCharacterDtoMapperInterface
{
    public function fromRequest(Request $request): CreateCharacterDto;
}