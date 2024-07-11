<?php

namespace App\Contracts\Mappers\In\Character;

use App\DTO\In\Character\ChangeCharacterDto;
use Symfony\Component\HttpFoundation\Request;

interface ChangeCharacterDtoMapperInterface
{
    public function fromRequest(Request $request): ChangeCharacterDto;
}