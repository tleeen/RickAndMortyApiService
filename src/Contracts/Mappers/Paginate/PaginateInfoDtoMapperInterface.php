<?php

declare(strict_types=1);

namespace App\Contracts\Mappers\Paginate;

use App\Contracts\Managers\Pagination\PaginateManagerInterface as Paginator;
use App\DTO\Paginate\PaginateInfoDto;

interface PaginateInfoDtoMapperInterface
{
    public function fromPaginator(Paginator $paginator, string $module): PaginateInfoDto;
}
