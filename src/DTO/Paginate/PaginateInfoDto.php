<?php

declare(strict_types=1);

namespace App\DTO\Paginate;

readonly class PaginateInfoDto
{
    public function __construct(
        public int $count,
        public int $pages,
        public ?string $next,
        public ?string $prev,
    ) {
    }
}
