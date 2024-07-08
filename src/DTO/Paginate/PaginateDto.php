<?php

namespace App\DTO\Paginate;

use App\Managers\Pagination\PaginateManager as Paginator;


class PaginateDto
{
    public readonly PaginateInfoDto $info;
    public readonly array $results;


    public function __construct(
        PaginateInfoDto $info,
        array $results
    )
    {
        $this->info = $info;
        $this->results = $results;
    }

    /**
     * @param Paginator $paginator
     * @param string $itemClassName
     * @param string $moduleName
     * @return self
     */
    public static function fromPaginator(Paginator $paginator, string $itemClassName, string $moduleName): self
    {
        return new self(
            info: PaginateInfoDto::fromPaginator($paginator, $moduleName),
            results: array_map(fn($item) => $itemClassName::fromModel($item), $paginator->getItems()->getQuery()->getResult())
        );
    }
}