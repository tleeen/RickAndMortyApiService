<?php

namespace App\DTO\In\Location;

use Symfony\Component\Validator\Constraints as Assert;

readonly class FilterDto
{
    #[Assert\Type('string')]
    public ?string $name;

    #[Assert\Type('string')]
    public ?string $type;

    #[Assert\Type('string')]
    public ?string $dimension;

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
}