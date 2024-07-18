<?php

declare(strict_types=1);

namespace App\Utils\Mappers\Paginate;

use App\Contracts\Managers\Pagination\PaginateManagerInterface as Paginator;
use App\Contracts\Mappers\Out\Character\CharacterDtoMapperInterface;
use App\Contracts\Mappers\Out\Episode\EpisodeDtoMapperInterface;
use App\Contracts\Mappers\Out\Location\LocationDtoMapperInterface;
use App\Contracts\Mappers\Paginate\PaginateDtoMapperInterface;
use App\Contracts\Mappers\Paginate\PaginateInfoDtoMapperInterface;
use App\DTO\Paginate\PaginateDto;

readonly class PaginateDtoMapper implements PaginateDtoMapperInterface
{
    public function __construct(
        private PaginateInfoDtoMapperInterface $paginateInfoDtoMapper
    ) {
    }

    public function fromPaginator(
        Paginator $paginator,
        CharacterDtoMapperInterface|EpisodeDtoMapperInterface|LocationDtoMapperInterface $dtoMapper,
        string $module
    ): PaginateDto {
        return new PaginateDto(
            info: $this->paginateInfoDtoMapper->fromPaginator($paginator, $module),
            results: array_map(
                function ($item) use ($dtoMapper) {
                    return $dtoMapper->fromModel($item);
                },
                $paginator->getItems()->getQuery()->getResult()
            )
        );
    }
}
