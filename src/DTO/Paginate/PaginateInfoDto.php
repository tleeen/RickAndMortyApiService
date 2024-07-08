<?php

namespace App\DTO\Paginate;

use App\DTO\Utils\Enums\BaseUrl;
use App\DTO\Utils\Enums\Prefixes\BasePrefixes;
use App\DTO\Utils\UrlMaker;
use App\Managers\Pagination\PaginateManager as Paginator;

class PaginateInfoDto
{
    public readonly int $count;
    public readonly int $pages;
    public readonly ?string $next;
    public readonly ?string $prev;


    public function __construct(
        int $count,
        int $pages,
        ?string $next,
        ?string $prev,
    )
    {
        $this->count = $count;
        $this->pages = $pages;
        $this->next = $next;
        $this->prev = $prev;
    }

    /**
     * @param Paginator $paginator
     * @param string $moduleName
     * @return self
     */
    public static function fromPaginator(Paginator $paginator, string $moduleName): self
    {
        return new self(
            count: $paginator->getTotal(),
            pages: $paginator->getLastPage(),
            next: $paginator->getNextPage() ? UrlMaker::makePaginatePage(
                BaseUrl::APP_URL->value
                , BasePrefixes::API->value
                , $moduleName
                , $paginator->getNextPage()) : $paginator->getNextPage(),
            prev: $paginator->getPreviousPage() ? UrlMaker::makePaginatePage(
                BaseUrl::APP_URL->value
                , BasePrefixes::API->value
                , $moduleName
                , $paginator->getPreviousPage()) : $paginator->getPreviousPage()
        );
    }
}