<?php

declare(strict_types=1);

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