<?php

namespace App\Utils\Mappers\Paginate;

use App\Contracts\Managers\UrlGeneration\UrlGenerateManagerInterface;
use App\DTO\Paginate\PaginateDto;
use App\Managers\Pagination\PaginateManager as Paginator;

class PaginateDtoMapper
{
    /**
     * @param Paginator $paginator
     * @param string $itemClassName
     * @param string $module
     * @param UrlGenerateManagerInterface $urlGenerator
     * @return PaginateDto
     */
    public static function fromPaginator(
        Paginator $paginator,
        string $itemClassName,
        string $module,
        UrlGenerateManagerInterface $urlGenerator
    ): PaginateDto
    {
        return new PaginateDto(
            info: PaginateInfoDtoMapper::fromPaginator($paginator, $module, $urlGenerator),
            results: array_map(fn($item) => $itemClassName::fromModel($item, $urlGenerator), $paginator->getItems()->getQuery()->getResult())
        );
    }
}