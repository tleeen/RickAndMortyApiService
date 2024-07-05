<?php

namespace App\DTO\Collection;

class CollectionDto
{
    public readonly array $results;

    public function __construct(
        array $results,
    ) {
        $this->results = $results;
    }

    /**
     * @param array $array
     * @param string $className
     * @return self
     */
    public static function fromArray(array $array, string $className): self
    {
        return new self(
            results: array_map(fn($item) => $className::fromModel($item), $array)
        );
    }
}