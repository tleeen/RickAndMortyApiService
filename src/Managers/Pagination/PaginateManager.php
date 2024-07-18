<?php

declare(strict_types=1);

namespace App\Managers\Pagination;

use App\Contracts\Managers\Pagination\PaginateManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;

class PaginateManager implements PaginateManagerInterface
{
    private int $total;
    private int $lastPage;
    private int $currentPage;
    private Paginator $items;

    public function paginate(QueryBuilder $query, ?int $page, ?int $limit): self
    {
        $page ??= 1;
        $limit ??= 10;

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

    public function getTotal(): int
    {
        return $this->total;
    }

    public function getLastPage(): int
    {
        return $this->lastPage;
    }

    public function getItems(): Paginator
    {
        return $this->items;
    }

    public function getNextPage(): ?int
    {
        return $this->currentPage < $this->lastPage ? $this->currentPage + 1 : null;
    }

    public function getPreviousPage(): ?int
    {
        return $this->currentPage > 1 ? $this->currentPage - 1 : null;
    }
}
