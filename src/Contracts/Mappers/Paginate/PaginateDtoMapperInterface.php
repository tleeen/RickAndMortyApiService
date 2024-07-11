<?php

namespace App\Contracts\Mappers\Paginate;

use App\Contracts\Mappers\Out\Character\CharacterDtoMapperInterface;
use App\Contracts\Mappers\Out\Episode\EpisodeDtoMapperInterface;
use App\Contracts\Mappers\Out\Location\LocationDtoMapperInterface;
use App\DTO\Paginate\PaginateDto;
use App\Managers\Pagination\PaginateManager as Paginator;

interface PaginateDtoMapperInterface
{
    public function fromPaginator(
        Paginator $paginator,
        CharacterDtoMapperInterface|EpisodeDtoMapperInterface|LocationDtoMapperInterface $dtoMapper,
        string $module
    ): PaginateDto;
}