<?php

namespace App\DTO\In\Episode;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class GetEpisodesDto
{
    #[Assert\Type('array')]
    public readonly ?array $ids;

    #[Assert\Type('integer')]
    #[Assert\Positive]
    public readonly ?int $page;

    #[Assert\Valid]
    public readonly FilterDto $filters;

    public function __construct(
        ?array $ids,
        ?int $page,
        FilterDto $filters
    )
    {
        $this->ids = $ids;
        $this->page = $page;
        $this->filters = $filters;
    }

    /**
     * @param Request $request
     * @return self
     */
    public static function fromRequest(Request $request): self
    {
        return new self(
            ids: array_map(fn($id) => (int)$id, $request->query->all('ids')),
            page: $request->query->get('page'),
            filters: FilterDto::fromRequest($request),
        );
    }
}