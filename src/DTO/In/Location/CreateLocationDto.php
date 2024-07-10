<?php

namespace App\DTO\In\Location;

use Symfony\Component\Validator\Constraints as Assert;

readonly class CreateLocationDto
{
    #[Assert\Type('string')]
    #[Assert\NotBlank]
    public string $name;

    #[Assert\Type('string')]
    #[Assert\NotBlank]
    public string $type;

    #[Assert\Type('string')]
    #[Assert\NotBlank]
    public string $dimension;

    public function __construct(
        string $name,
        string $type,
        string $dimension
    )
    {
        $this->name = $name;
        $this->type = $type;
        $this->dimension = $dimension;
    }
}