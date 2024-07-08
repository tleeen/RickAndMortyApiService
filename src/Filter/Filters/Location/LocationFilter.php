<?php

namespace App\Filter\Filters\Location;

use App\Filter\AbstractFilter;
use Doctrine\ORM\QueryBuilder;

class LocationFilter extends AbstractFilter
{
    protected function getCallbacks(): array
    {
        return [
            'name' => [$this, 'name'],
            'type' => [$this, 'type'],
            'dimension' => [$this, 'dimension'],
        ];
    }

    public function name(QueryBuilder $queryBuilder, string $value): void
    {
        $queryBuilder->andWhere('LOWER(location.name) LIKE LOWER(:name)')
            ->setParameter('name', '%' . strtolower($value) . '%');
    }

    public function type(QueryBuilder $queryBuilder, string $value): void
    {
        $queryBuilder->andWhere('LOWER(location.type) LIKE LOWER(:type)')
            ->setParameter('type', '%' . strtolower($value) . '%');
    }

    public function dimension(QueryBuilder $queryBuilder, string $value): void
    {
        $queryBuilder->andWhere('LOWER(location.dimension) LIKE LOWER(:dimension)')
            ->setParameter('dimension', '%' . strtolower($value) . '%');
    }
}