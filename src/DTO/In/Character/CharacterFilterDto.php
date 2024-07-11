<?php

namespace App\DTO\In\Character;

use App\Enums\Character\CharacterGender;
use App\Enums\Character\CharacterStatus;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @property string|null $name
 * @property string|null $status
 * @property string|null $species
 * @property string|null $type
 * @property string|null $gender
 */
class CharacterFilterDto
{
    public function __construct(
        #[Assert\Type(
            type: 'string',
            message: 'The name is not a valid {{ type }} or null.'
        )]
        public $name,

        #[Assert\Type(
            type: 'string',
            message: 'The status is not a valid {{ type }} or null.'
        )]
        #[Assert\Choice(
            choices: [
                CharacterStatus::ALIVE->value,
                CharacterStatus::DEAD->value,
                CharacterStatus::UNKNOWN->value,
            ],
            message: 'The status is not a {{ choices }}'
        )]
        public $status,

        #[Assert\Type(
            type: 'string',
            message: 'The species is not a valid {{ type }} or null.'
        )]
        public $species,

        #[Assert\Type(
            type: 'string',
            message: 'The type is not a valid {{ type }} or null.'
        )]
        public $type,

        #[Assert\Type(
            type: 'string',
            message: 'The gender is not a valid {{ type }} or null.'
        )]
        #[Assert\Choice(
            choices: [
                CharacterGender::MALE->value,
                CharacterGender::FEMALE->value,
                CharacterGender::UNKNOWN->value,
                CharacterGender::GENDERLESS->value
            ],
            message: 'The gender is not a {{ choices }}'
        )]
        public $gender
    )
    {
    }
}