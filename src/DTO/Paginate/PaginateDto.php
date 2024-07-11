<?php

namespace App\DTO\Paginate;

readonly class PaginateDto
{
    public function __construct(
        public PaginateInfoDto $info,
        public array           $results
    )
    {
    }
}