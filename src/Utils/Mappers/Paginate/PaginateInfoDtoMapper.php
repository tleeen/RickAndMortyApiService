<?php

declare(strict_types=1);

namespace App\Utils\Mappers\Paginate;

use App\Contracts\Mappers\Paginate\PaginateInfoDtoMapperInterface;
use App\DTO\Paginate\PaginateInfoDto;
use App\Managers\Pagination\PaginateManager as Paginator;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

readonly class PaginateInfoDtoMapper implements PaginateInfoDtoMapperInterface
{
    public function __construct(
        private UrlGeneratorInterface $urlGenerator,
    )
    {
    }

    public function fromPaginator(Paginator $paginator, string $module): PaginateInfoDto
    {
        return new PaginateInfoDto(
            count: $paginator->getTotal(),
            pages: $paginator->getLastPage(),
            next: $paginator->getNextPage() ? $this->urlGenerator->generate(
                    $module . '_get',
                    [],
                    UrlGeneratorInterface::ABSOLUTE_URL)
                . "?page="
                . $paginator->getNextPage() : $paginator->getNextPage(),
            prev: $paginator->getPreviousPage() ? $this->urlGenerator->generate($module . '_get',
                    [],
                    UrlGeneratorInterface::ABSOLUTE_URL)
                . "?page="
                . $paginator->getPreviousPage() : $paginator->getPreviousPage()
        );
    }
}