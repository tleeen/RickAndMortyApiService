<?php

declare(strict_types=1);

namespace App\Filter;

use Doctrine\ORM\QueryBuilder;

abstract class AbstractIFilter implements FilterInterface
{
    protected object $filters;

    public function __construct(object $filters)
    {
        $this->filters = $filters;
    }

    abstract protected function getCallbacks(): array;

    public function apply(QueryBuilder $queryBuilder): void
    {
        foreach ($this->getCallbacks() as $name => $callback) {
            if (isset($this->filters->$name)) {
                call_user_func($callback, $queryBuilder, $this->filters->$name);
            }
        }
    }
}
