<?php

namespace App\DTO\In\Character;

use Symfony\Component\Validator\Constraints as Assert;

readonly class FilterDto
{
    #[Assert\Type('string')]
    public ?string $name;

    #[Assert\Type('string')]
    #[Assert\Choice(choices: ['Alive', 'Dead', 'unknown'])]
    public ?string $status;

    #[Assert\Type('string')]
    public ?string $species;

    #[Assert\Type('string')]
    public ?string $type;

    #[Assert\Type('string')]
    #[Assert\Choice(choices: ['Female', 'Male', 'Genderless', 'unknown'])]
    public ?string $gender;

    public function __construct(
        ?string $name,
        ?string $status,
        ?string $species,
        ?string $type,
        ?string $gender
    )
    {
        $this->name = $name;
        $this->status = $status;
        $this->species = $species;
        $this->type = $type;
        $this->gender = $gender;
    }
}