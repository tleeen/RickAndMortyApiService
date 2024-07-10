<?php

namespace App\DTO\In\Location;

use Symfony\Component\Validator\Constraints as Assert;

readonly class ChangeLocationDto
{
    #[Assert\Type('integer')]
    #[Assert\NotBlank]
    #[Assert\Positive]
    public int $id;

    #[Assert\Type('string')]
    public ?string $name;

    #[Assert\Type('string')]
    public ?string $type;

    #[Assert\Type('string')]
    public ?string $dimension;

    public function __construct(
        int     $id,
        ?string $name,
        ?string $type,
        ?string $dimension
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->type = $type;
        $this->dimension = $dimension;
    }
}