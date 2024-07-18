<?php

declare(strict_types=1);

namespace App\DTO\In\Character;

use App\Enums\Character\CharacterGender;
use App\Enums\Character\CharacterStatus;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @property int         $id
 * @property string|null $name
 * @property string|null $status
 * @property string|null $species
 * @property string|null $type
 * @property string|null $gender
 * @property int|null    $originId
 * @property int|null    $locationId
 * @property string|null $image
 */
class ChangeCharacterDto
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
         * @var int
         */
        public $id,

        #[Assert\Type(
            type: 'string',
            message: 'The name is not a valid {{ type }} or null.'
        )]
        /**
         * @var string|null
         */
        public $name,

        #[Assert\Type(
            type: 'string',
            message: 'The status is not a valid {{ type }} or null.'
        )]
        #[Assert\Choice(
            callback: [CharacterStatus::class, 'values'],
            message: 'The status is not a {{ choices }}'
        )]
        /**
         * @var string|null
         */
        public $status,

        #[Assert\Type(
            type: 'string',
            message: 'The species is not a valid {{ type }} or null.'
        )]
        /**
         * @var string|null
         */
        public $species,

        #[Assert\Type(
            type: 'string',
            message: 'The type is not a valid {{ type }} or null.'
        )]
        /**
         * @var string|null
         */
        public $type,

        #[Assert\Type(
            type: 'string',
            message: 'The gender is not a valid {{ type }} or null.'
        )]
        #[Assert\Choice(
            callback: [CharacterGender::class, 'values'],
            message: 'The gender is not a {{ choices }}'
        )]
        /**
         * @var string|null
         */
        public $gender,

        #[Assert\Type(
            type: 'integer',
            message: 'The originId is not a valid {{ type }} or null.'
        )]
        #[Assert\PositiveOrZero(
            message: 'The originId is not a positive.'
        )]
        /**
         * @var int|null
         */
        public $originId,

        #[Assert\Type(
            type: 'integer',
            message: 'The locationId is not a valid {{ type }} or null.'
        )]
        #[Assert\PositiveOrZero(
            message: 'The locationId is not a positive.'
        )]
        /**
         * @var int|null
         */
        public $locationId,

        #[Assert\Type(
            type: 'string',
            message: 'The image is not a valid {{ type }} or null.'
        )]
        #[Assert\Regex(
            pattern: '/^.+\.jpeg$/i',
            message: 'The image is not a valid {{ pattern }}'
        )]
        /**
         * @var string|null
         */
        public $image
    ) {
    }
}
