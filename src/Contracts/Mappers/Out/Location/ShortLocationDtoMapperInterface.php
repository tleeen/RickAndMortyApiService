<?php

declare(strict_types=1);

namespace App\Contracts\Mappers\Out\Location;

use App\DTO\Out\Location\ShortLocationDto;
use App\Entity\Location;

interface ShortLocationDtoMapperInterface
{
    public function fromModel(Location $location): ShortLocationDto;
}
