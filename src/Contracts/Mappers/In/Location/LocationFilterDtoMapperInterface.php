<?php

namespace App\Contracts\Mappers\In\Location;

use App\DTO\In\Location\LocationFilterDto;
use Symfony\Component\HttpFoundation\Request;

interface LocationFilterDtoMapperInterface
{
    public function fromRequest(Request $request): LocationFilterDto;
}