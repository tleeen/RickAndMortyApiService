<?php

namespace App\Filter;

use Doctrine\ORM\QueryBuilder;

interface FilterInterface
{
    public function apply(QueryBuilder $queryBuilder): void;
}