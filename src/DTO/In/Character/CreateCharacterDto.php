<?php

namespace App\DTO\In\Character;

use App\Enums\Character\CharacterGender;
use App\Enums\Character\CharacterStatus;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @property string $name
 * @property string $status
 * @property string $species
 * @property string $type
 * @property string $gender
 * @property int $originId
 * @property int $locationId
 * @property string $image
 */
class CreateCharacterDto
{
    public function __construct(
        #[Assert\Type(
            type: 'string',
            message: 'The name is not a valid {{ type }}.'
        )]
        #[Assert\NotBlank]
        public $name,

        #[Assert\Type(
            type: 'string',
            message: 'The status is not a valid {{ type }}.'
        )]
        #[Assert\Choice(
            choices: [
                CharacterStatus::ALIVE->value,
                CharacterStatus::DEAD->value,
                CharacterStatus::UNKNOWN->value,
            ],
            message: 'The status is not a {{ choices }}'
        )]
        #[Assert\NotBlank]
        public $status,

        #[Assert\Type(
            type: 'string',
            message: 'The species is not a valid {{ type }}.'
        )]
        #[Assert\NotBlank]
        public $species,

        #[Assert\Type(
            type: 'string',
            message: 'The type is not a valid {{ type }}.'
        )]
        #[Assert\NotNull]
        public $type,

        #[Assert\Type(
            type: 'string',
            message: 'The gender is not a valid {{ type }}.'
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
        #[Assert\NotBlank]
        public $gender,

        #[Assert\Type(
            type: 'integer',
            message: 'The originId is not a valid {{ type }}.'
        )]
        #[Assert\Positive(
            message: 'The originId is not a positive.'
        )]
        #[Assert\NotNull]
        public $originId,

        #[Assert\Type(
            type: 'integer',
            message: 'The locationId is not a valid {{ type }}.'
        )]
        #[Assert\Positive(
            message: 'The locationId is not a positive.'
        )]
        #[Assert\NotNull]
        public $locationId,

        #[Assert\Type(
            type: 'string',
            message: 'The image is not a valid {{ type }}.'
        )]
        #[Assert\Regex(
            pattern: '/^.+\.jpeg$/i',
            message: 'The image is not a valid {{ pattern }}'
        )]
        #[Assert\NotBlank]
        public $image
    )
    {
    }
}