<?php

namespace App\DTO\In\Character;

use App\Enums\Character\CharacterGender;
use App\Enums\Character\CharacterStatus;
use Symfony\Component\Validator\Constraints as Assert;

class UpdateCharacterDto
{
    #[Assert\Type('integer')]
    #[Assert\NotBlank]
    #[Assert\Positive]
    public readonly int $id;

    #[Assert\Type('string')]
    #[Assert\NotBlank]
    public readonly string $name;

    #[Assert\Type('string')]
    #[Assert\Choice(choices: [
        CharacterStatus::ALIVE->value,
        CharacterStatus::DEAD->value,
        CharacterStatus::UNKNOWN->value,
    ])]
    #[Assert\NotBlank]
    public readonly ?string $status;

    #[Assert\Type('string')]
    #[Assert\NotBlank]
    public readonly ?string $species;

    #[Assert\Type('string')]
    #[Assert\NotBlank]
    public readonly ?string $type;

    #[Assert\Type('string')]
    #[Assert\Choice(choices: [
        CharacterGender::MALE->value,
        CharacterGender::FEMALE->value,
        CharacterGender::UNKNOWN->value,
        CharacterGender::GENDERLESS->value,
    ])]
    #[Assert\NotBlank]
    public readonly ?string $gender;

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
        int $id,
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
}