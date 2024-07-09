<?php

namespace App\DTO\In\Episode;

use Symfony\Component\Validator\Constraints as Assert;

class GetEpisodesDto
{
    #[Assert\Type('array')]
    public readonly ?array $ids;

    #[Assert\Type('integer')]
    #[Assert\LessThanOrEqual(20)]
    #[Assert\Positive]
    public readonly ?int $page;

    #[Assert\Type('integer')]
    #[Assert\LessThanOrEqual(20)]
    #[Assert\Positive]
    public readonly ?int $limit;

    #[Assert\Valid]
    public readonly FilterDto $filters;

    public function __construct(
        ?array $ids,
        ?int $page,
        ?int $limit,
        FilterDto $filters
    )
    {
        $this->ids = $ids;
        $this->page = $page;
        $this->limit = $limit;
        $this->filters = $filters;
    }
}