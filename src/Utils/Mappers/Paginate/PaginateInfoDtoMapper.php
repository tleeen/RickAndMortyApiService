<?php

namespace App\Utils\Mappers\Paginate;

use App\Contracts\Managers\UrlGeneration\UrlGenerateManagerInterface;
use App\DTO\Paginate\PaginateInfoDto;
use App\Managers\Pagination\PaginateManager as Paginator;

class PaginateInfoDtoMapper
{
    /**
     * @param Paginator $paginator
     * @param string $module
     * @param UrlGenerateManagerInterface $urlGenerator
     * @return PaginateInfoDto
     */
    public static function fromPaginator(Paginator $paginator, string $module, UrlGenerateManagerInterface $urlGenerator): PaginateInfoDto
    {
        return new PaginateInfoDto(
            count: $paginator->getTotal(),
            pages: $paginator->getLastPage(),
            next: $paginator->getNextPage() ? $urlGenerator->generate(
                $module . '_get',
                [],
                    UrlGenerateManagerInterface::ABSOLUTE_URL)
                . "?page="
                . $paginator->getNextPage() : $paginator->getNextPage(),
            prev: $paginator->getPreviousPage() ? $urlGenerator->generate($module . '_get',
                    [],
                    UrlGenerateManagerInterface::ABSOLUTE_URL)
                . "?page="
                . $paginator->getPreviousPage() : $paginator->getPreviousPage()
        );
    }
}