<?php

namespace App\DTO\In\Character;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class CreateCharacterDto
{
    #[Assert\Type('string')]
    #[Assert\NotBlank]
    public readonly string $name;

    #[Assert\Type('string')]
    #[Assert\Choice(choices: ['Alive', 'Dead', 'unknown'])]
    #[Assert\NotBlank]
    public readonly string $status;

    #[Assert\Type('string')]
    #[Assert\NotBlank]
    public readonly string $species;

    #[Assert\Type('string')]
    public readonly ?string $type;

    #[Assert\Type('string')]
    #[Assert\Choice(choices: ['Female', 'Male', 'Genderless', 'unknown'])]
    #[Assert\NotBlank]
    public readonly string $gender;

    #[Assert\Type('integer')]
    #[Assert\NotBlank]
    #[Assert\Positive]
    public readonly int $originId;

    #[Assert\Type('integer')]
    #[Assert\NotBlank]
    #[Assert\Positive]
    public readonly int $locationId;

    #[Assert\Type('string')]
    #[Assert\NotBlank]
    public readonly string $image;

    public function __construct(
        string $name,
        string $status,
        string $species,
        ?string $type,
        string $gender,
        int $originId,
        int $locationId,
        string $image
    )
    {
        $this->name = $name;
        $this->status = $status;
        $this->species = $species;
        $this->type = $type;
        $this->gender = $gender;
        $this->originId = $originId;
        $this->locationId = $locationId;
        $this->image = $image;
    }

    /**
     * @param Request $request
     * @return self
     */
    public static function fromRequest(Request $request): self
    {
        $character = $request->toArray();
        return new self(
            name: $character['name'],
            status: $character['status'],
            species: $character['species'],
            type: $character['type'] ?? null,
            gender: $character['gender'],
            originId: $character['originId'],
            locationId: $character['locationId'],
            image: $character['image'],
        );
    }
}