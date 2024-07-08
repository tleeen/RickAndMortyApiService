<?php

namespace App\Filter;

use Doctrine\ORM\QueryBuilder;

interface IFilter
{
    public function apply(QueryBuilder $queryBuilder): void;
}