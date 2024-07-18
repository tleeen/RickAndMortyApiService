<?php

declare(strict_types=1);

namespace App\Filter\Filters\Character;

use App\Filter\AbstractIFilter;
use Doctrine\ORM\QueryBuilder;

class CharacterFilter extends AbstractIFilter
{
    protected function getCallbacks(): array
    {
        return [
            'name' => [$this, 'name'],
            'status' => [$this, 'status'],
            'species' => [$this, 'species'],
            'type' => [$this, 'type'],
            'gender' => [$this, 'gender'],
        ];
    }

    public function name(QueryBuilder $queryBuilder, ?string $value): void
    {
        $queryBuilder->andWhere('LOWER(character.name) LIKE LOWER(:name)')
            ->setParameter('name', '%'.strtolower($value).'%');
    }

    public function status(QueryBuilder $queryBuilder, ?string $value): void
    {
        $queryBuilder->andWhere('character.status = :status')
            ->setParameter('status', $value);
    }

    public function species(QueryBuilder $queryBuilder, ?string $value): void
    {
        $queryBuilder->andWhere('LOWER(character.species) LIKE LOWER(:species)')
            ->setParameter('species', '%'.strtolower($value).'%');
    }

    public function type(QueryBuilder $queryBuilder, ?string $value): void
    {
        $queryBuilder->andWhere('LOWER(character.type) LIKE LOWER(:type)')
            ->setParameter('type', '%'.strtolower($value).'%');
    }

    public function gender(QueryBuilder $queryBuilder, ?string $value): void
    {
        $queryBuilder->andWhere('character.gender = :gender')
            ->setParameter('gender', $value);
    }
}
