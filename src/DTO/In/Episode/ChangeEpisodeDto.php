<?php

declare(strict_types=1);

namespace App\DTO\In\Episode;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * @property int $id
 * @property string|null $name
 * @property string|null $airDate
 * @property string|null $code
 * @property int[]|null $characterIds
 */
class ChangeEpisodeDto
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
            message: 'The name is not a valid {{ type }} or null.'
        )]
        /**
         * @var string|null
         */
        public $name,

        #[Assert\Date(
            message: 'The air date "{{ value }}" is not a valid date or null.'
        )]
        /**
         * @var string|null
         */
        public $airDate,

        #[Assert\Type(
            type: 'string',
            message: 'The code must be a {{ type }} or null.'
        )]
        #[Assert\Regex(
            pattern: '/^S\d{2}E\d{2}$/',
            message: 'The code "{{ value }}" is not valid. It should be in the format "SxxExx" where x is a digit.'
        )]
        /**
         * @var string|null
         */
        public $code,

        #[Assert\Type(
            type: 'array',
            message: 'The characterIds  must be a {{ type }} or null.'
        )]
        #[Assert\All([
            new Assert\Type([
                'type' => 'integer',
                'message' => 'The characterIds item is not a valid integer.'
            ]),
            new Assert\Positive([
                'message' => 'The characterIds item is not a positive.'
            ])
        ])]
        /**
         * @var int[]|null
         */
        public $characterIds
    )
    {
    }
}