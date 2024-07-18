<?php

declare(strict_types=1);

namespace App\Contracts\Mappers\In\Location;

use App\DTO\In\Location\CreateLocationDto;
use Symfony\Component\HttpFoundation\Request;

interface CreateLocationDtoMapperInterface
{
    public function fromRequest(Request $request): CreateLocationDto;
}
