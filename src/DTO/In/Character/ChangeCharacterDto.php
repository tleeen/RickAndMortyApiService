<?php

namespace App\DTO\In\Character;

use App\Enums\Character\CharacterGender;
use App\Enums\Character\CharacterStatus;
use Symfony\Component\Validator\Constraints as Assert;


readonly class ChangeCharacterDto
{
    #[Assert\Type('integer')]
    #[Assert\NotBlank]
    public int $id;

    #[Assert\Type('string')]
    public ?string $name;

    #[Assert\Type('string')]
    #[Assert\Choice(choices: [
        CharacterStatus::ALIVE->value,
        CharacterStatus::DEAD->value,
        CharacterStatus::UNKNOWN->value,
    ])]
    public ?string $status;

    #[Assert\Type('string')]
    public ?string $species;

    #[Assert\Type('string')]
    public ?string $type;

    #[Assert\Type('string')]
    #[Assert\Choice(choices: [
        CharacterGender::MALE->value,
        CharacterGender::FEMALE->value,
        CharacterGender::UNKNOWN->value,
        CharacterGender::GENDERLESS->value,
    ])]
    public ?string $gender;

    #[Assert\Type('integer')]
    #[Assert\Positive]
    public ?int $originId;

    #[Assert\Type('integer')]
    #[Assert\Positive]
    public ?int $locationId;

    #[Assert\Type('string')]
    public ?string $image;

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
}