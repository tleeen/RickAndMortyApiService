<?php

namespace App\DTO\In\Location;

use Symfony\Component\Validator\Constraints as Assert;

readonly class UpdateLocationDto
{
    #[Assert\Type('integer')]
    #[Assert\NotBlank]
    #[Assert\Positive]
    public int $id;

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
        int    $id,
        string $name,
        string $type,
        string $dimension
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->type = $type;
        $this->dimension = $dimension;
    }
}