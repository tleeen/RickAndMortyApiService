<?php

namespace App\DTO\In\Character;

use App\Enums\Character\CharacterGender;
use App\Enums\Character\CharacterStatus;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @property int $id
 * @property string $name
 * @property string $status
 * @property string $species
 * @property string $type
 * @property string $gender
 * @property int $originId
 * @property int $locationId
 * @property string $image
 */
class UpdateCharacterDto
{
    public function __construct(
        #[Assert\Type(
            type: 'integer',
            message: 'The id is not a valid {{ type }}.'
        )]
        #[Assert\Positive(
            message: 'The id is not a positive.'
        )]
        #[Assert\NotNull]
        /**
         * @var integer
         */
        public $id,

        #[Assert\Type(
            type: 'string',
            message: 'The name is not a valid {{ type }}.'
        )]
        #[Assert\NotBlank]
        /**
         * @var string
         */
        public $name,

        #[Assert\Type(
            type: 'string',
            message: 'The status is not a valid {{ type }}.'
        )]
        #[Assert\Choice(
            callback: [CharacterStatus::class, 'values'],
            message: 'The status is not a {{ choices }}'
        )]
        #[Assert\NotBlank]
        /**
         * @var string
         */
        public $status,

        #[Assert\Type(
            type: 'string',
            message: 'The species is not a valid {{ type }}.'
        )]
        #[Assert\NotBlank]
        /**
         * @var string
         */
        public $species,

        #[Assert\Type(
            type: 'string',
            message: 'The type is not a valid {{ type }}.'
        )]
        #[Assert\NotNull]
        /**
         * @var string
         */
        public $type,

        #[Assert\Type(
            type: 'string',
            message: 'The gender is not a valid {{ type }}.'
        )]
        #[Assert\Choice(
            callback: [CharacterGender::class, 'values'],
            message: 'The gender is not a {{ choices }}'
        )]
        #[Assert\NotBlank]
        /**
         * @var string
         */
        public $gender,

        #[Assert\Type(
            type: 'integer',
            message: 'The originId is not a valid {{ type }}.'
        )]
        #[Assert\Positive(
            message: 'The originId is not a positive.'
        )]
        #[Assert\NotNull]
        /**
         * @var integer
         */
        public $originId,

        #[Assert\Type(
            type: 'integer',
            message: 'The locationId is not a valid {{ type }}.'
        )]
        #[Assert\Positive(
            message: 'The locationId is not a positive.'
        )]
        #[Assert\NotNull]
        /**
         * @var integer
         */
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
        /**
         * @var string
         */
        public $image
    )
    {
    }
}