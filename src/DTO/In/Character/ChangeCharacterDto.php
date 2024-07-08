<?php

namespace App\DTO\In\Character;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;


class ChangeCharacterDto
{
    #[Assert\Type('integer')]
    #[Assert\NotBlank]
    public readonly int $id;

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

    #[Assert\Type('integer')]
    public readonly ?int $originId;

    #[Assert\Type('integer')]
    public readonly ?int $locationId;

    #[Assert\Type('string')]
    public readonly ?string $image;

    public function __construct(
        int      $id,
        ?string $name,
        ?string $status,
        ?string $species,
        ?string $type,
        ?string $gender,
        ?int    $originId,
        ?int    $locationId,
        ?string $image
    )
    {
        $this->id = $id;
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
    public
    static function fromRequest(Request $request): self
    {
        $character = $request->toArray();
        return new self(
            id: $request->get('id'),
            name: $character['name'] ?? null,
            status: $character['status'] ?? null,
            species: $character['species'] ?? null,
            type: $character['type'] ?? null,
            gender: $character['gender'] ?? null,
            originId: $character['originId'] ?? null,
            locationId: $character['locationId'] ?? null,
            image: $character['image'] ?? null,
        );
    }
}