<?php

declare(strict_types=1);

namespace App\Contracts\Mappers\Paginate;

use App\DTO\Paginate\PaginateInfoDto;
use App\Managers\Pagination\PaginateManager as Paginator;

interface PaginateInfoDtoMapperInterface
{
    public function fromPaginator(Paginator $paginator, string $module): PaginateInfoDto;
}
