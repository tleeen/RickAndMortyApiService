<?php

namespace App\DTO\In\Character;

use App\Enums\Character\CharacterGender;
use App\Enums\Character\CharacterStatus;
use Symfony\Component\Validator\Constraints as Assert;

readonly class CreateCharacterDto
{
    #[Assert\Type('string')]
    #[Assert\NotBlank]
    public string $name;

    #[Assert\Type('string')]
    #[Assert\Choice(choices: [
        CharacterStatus::ALIVE->value,
        CharacterStatus::DEAD->value,
        CharacterStatus::UNKNOWN->value,
    ])]
    #[Assert\NotBlank]
    public ?string $status;

    #[Assert\Type('string')]
    #[Assert\NotBlank]
    public ?string $species;

    #[Assert\Type('string')]
    #[Assert\NotBlank]
    public ?string $type;

    #[Assert\Type('string')]
    #[Assert\Choice(choices: [
        CharacterGender::MALE->value,
        CharacterGender::FEMALE->value,
        CharacterGender::UNKNOWN->value,
        CharacterGender::GENDERLESS->value,
    ])]
    #[Assert\NotBlank]
    public ?string $gender;

    #[Assert\Type('integer')]
    #[Assert\NotBlank]
    #[Assert\Positive]
    public int $originId;

    #[Assert\Type('integer')]
    #[Assert\NotBlank]
    #[Assert\Positive]
    public int $locationId;

    #[Assert\Type('string')]
    #[Assert\NotBlank]
    public string $image;

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
}