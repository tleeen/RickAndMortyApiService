<?php

namespace App\DTO\Paginate;

readonly class PaginateInfoDto
{
    public int $count;
    public int $pages;
    public ?string $next;
    public ?string $prev;


    public function __construct(
        int     $count,
        int     $pages,
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