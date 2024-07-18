<?php

declare(strict_types=1);

namespace App\Contracts\Mappers\Paginate;

use App\Contracts\Managers\Pagination\PaginateManagerInterface as Paginator;
use App\Contracts\Mappers\Out\Character\CharacterDtoMapperInterface;
use App\Contracts\Mappers\Out\Episode\EpisodeDtoMapperInterface;
use App\Contracts\Mappers\Out\Location\LocationDtoMapperInterface;
use App\DTO\Paginate\PaginateDto;

interface PaginateDtoMapperInterface
{
    public function fromPaginator(
        Paginator $paginator,
        CharacterDtoMapperInterface|EpisodeDtoMapperInterface|LocationDtoMapperInterface $dtoMapper,
        string $module
    ): PaginateDto;
}
