<?php

declare(strict_types=1);

namespace App\Contracts\Mappers\In\Location;

use App\DTO\In\Location\GetLocationsDto;
use Symfony\Component\HttpFoundation\Request;

interface GetLocationsDtoMapperInterface
{
    public function fromRequest(Request $request): GetLocationsDto;
}
