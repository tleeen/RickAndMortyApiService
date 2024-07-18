<?php

declare(strict_types=1);

namespace App\Contracts\Managers\Pagination;

use App\Entity\Character;
use App\Entity\Episode;
use App\Entity\Location;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;

interface PaginateManagerInterface
{
    public function paginate(QueryBuilder $query, ?int $page, ?int $limit): self;

    public function getTotal(): int;

    public function getLastPage(): int;

    /**
     * @return Paginator<Character|Episode|Location>
     */
    public function getItems(): Paginator;

    public function getNextPage(): ?int;

    public function getPreviousPage(): ?int;
}
