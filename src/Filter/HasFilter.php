<?php

namespace App\Filter;

use Doctrine\ORM\QueryBuilder;

trait HasFilter
{
    public function filterBy(QueryBuilder $queryBuilder, IFilter $filter): QueryBuilder
    {
        $filter->apply($queryBuilder);
        return $queryBuilder;
    }
}