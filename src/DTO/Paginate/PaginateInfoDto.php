<?php

namespace App\DTO\Paginate;

class PaginateInfoDto
{
    public readonly int $count;
    public readonly int $pages;
    public readonly ?string $next;
    public readonly ?string $prev;


    public function __construct(
        int $count,
        int $pages,
        ?string $next,
        ?string $prev,
    )
    {
        $this->count = $count;
        $this->pages = $pages;
        $this->next = $next;
        $this->prev = $prev;
    }
}