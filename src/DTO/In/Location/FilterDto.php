<?php

namespace App\DTO\In\Location;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class FilterDto
{
    #[Assert\Type('string')]
    public readonly ?string $name;

    #[Assert\Type('string')]
    public readonly ?string $type;

    #[Assert\Type('string')]
    public readonly ?string $dimension;

    public function __construct(
        ?string $name,
        ?string $type,
        ?string $dimension
    )
    {
       $this->name = $name;
       $this->type = $type;
       $this->dimension = $dimension;
    }

    /**
     * @param Request $request
     * @return self
     */
    public static function fromRequest(Request $request): self
    {
        return new self(
            name: $request->query->get('name') ?? null,
            type: $request->query->get('type') ?? null,
            dimension: $request->query->get('dimension') ?? null
        );
    }
}