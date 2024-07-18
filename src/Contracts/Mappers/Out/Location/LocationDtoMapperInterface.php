<?php

declare(strict_types=1);

namespace App\Contracts\Mappers\Out\Location;

use App\DTO\Out\Location\LocationDto;
use App\DTO\Paginate\PaginateDto;
use App\Entity\Location;
use App\Managers\Pagination\PaginateManager as Paginator;

interface LocationDtoMapperInterface
{
    public function fromModel(Location $location): LocationDto;

    public function fromPaginator(Paginator $paginator): PaginateDto;
}
