<?php

namespace App\DTO\In\Location;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class GetLocationsDto
{
    #[Assert\Type('array')]
    public readonly ?array $ids;

    public function __construct(
        ?array $ids,
    ) {
        $this->ids = $ids;
    }

    /**
     * @param Request $request
     * @return self
     */
    public static function fromRequest(Request $request): self
    {
        return new self(
            ids: array_map('intval', $request->query->all('ids'))
        );
    }
}