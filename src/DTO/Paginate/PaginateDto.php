<?php

namespace App\DTO\Paginate;

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
}