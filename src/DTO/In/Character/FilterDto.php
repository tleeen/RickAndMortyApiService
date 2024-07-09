<?php

namespace App\DTO\In\Character;

use Symfony\Component\Validator\Constraints as Assert;

class FilterDto
{
    #[Assert\Type('string')]
    public readonly ?string $name;

    #[Assert\Type('string')]
    #[Assert\Choice(choices: ['Alive', 'Dead', 'unknown'])]
    public readonly ?string $status;

    #[Assert\Type('string')]
    public readonly ?string $species;

    #[Assert\Type('string')]
    public readonly ?string $type;

    #[Assert\Type('string')]
    #[Assert\Choice(choices: ['Female', 'Male', 'Genderless', 'unknown'])]
    public readonly ?string $gender;

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