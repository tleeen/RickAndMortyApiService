<?php

namespace App\Managers\Pagination;

use App\Contracts\Managers\Pagination\IPaginateManager;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;

class PaginateManager implements IPaginateManager
{
    private int $total;
    private int $lastPage;

    private int $currentPage;
    private Paginator $items;

    /**
     * @param Query|QueryBuilder $query
     * @param int $page
     * @param int $limit
     * @return self
     */
    public function paginate(Query|QueryBuilder $query, int $page = 1, int $limit = 3): self
    {
        $paginator = new Paginator($query);

        $paginator
            ->getQuery()
            ->setFirstResult($limit * ($page - 1))
            ->setMaxResults($limit);

        $this->currentPage = $page;
        $this->total = $paginator->count();
        $this->lastPage = (int) ceil($paginator->count() / $paginator->getQuery()->getMaxResults());
        $this->items = $paginator;

        return $this;
    }

    /**
     * @return int
     */
    public function getTotal(): int
    {
        return $this->total;
    }

    /**
     * @return int
     */
    public function getLastPage(): int
    {
        return $this->lastPage;
    }

    /**
     * @return Paginator
     */
    public function getItems(): Paginator
    {
        return $this->items;
    }

    /**
     * @return int|null
     */
    public function getNextPage(): ?int
    {
        return $this->currentPage < $this->lastPage ? $this->currentPage + 1 : null;
    }

    /**
     * @return int|null
     */
    public function getPreviousPage(): ?int
    {
        return $this->currentPage > 1 ? $this->currentPage - 1 : null;
    }
}