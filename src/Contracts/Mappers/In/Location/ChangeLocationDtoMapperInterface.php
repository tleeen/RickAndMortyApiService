<?php

namespace App\Contracts\Mappers\In\Location;

use App\DTO\In\Location\ChangeLocationDto;
use Symfony\Component\HttpFoundation\Request;

interface ChangeLocationDtoMapperInterface
{
    public function fromRequest(Request $request): ChangeLocationDto;
}