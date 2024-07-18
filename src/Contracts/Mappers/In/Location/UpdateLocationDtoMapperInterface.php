<?php

declare(strict_types=1);

namespace App\Contracts\Mappers\In\Location;

use App\DTO\In\Location\UpdateLocationDto;
use Symfony\Component\HttpFoundation\Request;

interface UpdateLocationDtoMapperInterface
{
    public function fromRequest(Request $request): UpdateLocationDto;
}