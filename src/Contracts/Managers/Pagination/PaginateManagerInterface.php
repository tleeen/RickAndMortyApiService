<?php

namespace App\Contracts\Managers\Pagination;

use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;

interface PaginateManagerInterface
{
    /**
     * @param Query|QueryBuilder $query
     * @param int $page
     * @param int $limit
     * @return self
     */
    public function paginate(Query|QueryBuilder $query, int $page, int $limit): self;

    /**
     * @return int
     */
    public function getTotal(): int;

    /**
     * @return int
     */
    public function getLastPage(): int;

    /**
     * @return Paginator
     */
    public function getItems(): Paginator;

    /**
     * @return int|null
     */
    public function getNextPage(): ?int;

    /**
     * @return int|null
     */
    public function getPreviousPage(): ?int;
}