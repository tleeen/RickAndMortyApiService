<?php

namespace App\Filter\Filters\Episode;

use App\Filter\AbstractIFilter;
use Doctrine\ORM\QueryBuilder;

class EpisodeFilter extends AbstractIFilter
{
    protected function getCallbacks(): array
    {
        return [
            'name' => [$this, 'name'],
            'code' => [$this, 'code'],
        ];
    }

    public function name(QueryBuilder $queryBuilder, ?string $value): void
    {
        $queryBuilder->andWhere('LOWER(episode.name) LIKE LOWER(:name)')
            ->setParameter('name', '%' . strtolower($value) . '%');
    }

    public function code(QueryBuilder $queryBuilder, ?string $value): void
    {
        $queryBuilder->andWhere('episode.code = :code')
            ->setParameter('code', $value);
    }
}