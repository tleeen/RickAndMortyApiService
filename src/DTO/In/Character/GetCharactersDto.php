<?php

namespace App\DTO\In\Character;

use Symfony\Component\Validator\Constraints as Assert;

readonly class GetCharactersDto
{
    #[Assert\Type('array')]
    public ?array $ids;

    #[Assert\Type('integer')]
    #[Assert\Positive]
    public ?int $page;

    #[Assert\Type('integer')]
    #[Assert\LessThanOrEqual(20)]
    #[Assert\Positive]
    public ?int $limit;

    #[Assert\Valid]
    public FilterDto $filters;

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