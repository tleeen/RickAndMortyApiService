<?php

namespace App\DTO\In\Location;

use Symfony\Component\HttpFoundation\Request;
use App\DTO\In\Location\FilterDto;
use Symfony\Component\Validator\Constraints as Assert;

class GetLocationsDto
{
    #[Assert\Type('array')]
    public readonly ?array $ids;

    #[Assert\Type('integer')]
    #[Assert\Positive]
    public readonly ?int $page;

    #[Assert\Type('integer')]
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

    /**
     * @param Request $request
     * @return self
     */
    public static function fromRequest(Request $request): self
    {
        return new self(
            ids: array_map(fn($id) => (int)$id, $request->query->all('ids')),
            page: $request->query->get('page'),
            limit: $request->query->get('limit'),
            filters: FilterDto::fromRequest($request),
        );
    }
}