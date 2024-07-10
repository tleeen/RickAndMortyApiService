<?php

namespace App\DTO\Paginate;

readonly class PaginateDto
{
    public PaginateInfoDto $info;
    public array $results;


    public function __construct(
        PaginateInfoDto $info,
        array           $results
    )
    {
        $this->info = $info;
        $this->results = $results;
    }
}