<?php

namespace App\Contracts\Managers\Pagination;

use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;

interface PaginateManagerInterface
{
    public function paginate(QueryBuilder $query, int $page, int $limit): self;

    public function getTotal(): int;

    public function getLastPage(): int;

    public function getItems(): Paginator;

    public function getNextPage(): ?int;

    public function getPreviousPage(): ?int;
}