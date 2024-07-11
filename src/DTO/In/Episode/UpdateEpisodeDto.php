<?php

namespace App\DTO\In\Episode;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * @property int $id
 * @property string $name
 * @property string $airDate
 * @property string $code
 * @property array $characterIds
 */
class UpdateEpisodeDto
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
        public $id,

        #[Assert\Type(
            type: 'string',
            message: 'The name is not a valid {{ type }}.'
        )]
        #[Assert\NotBlank]
        public $name,

        #[Assert\Date(
            message: 'The air date "{{ value }}" is not a valid date.'
        )]
        #[Assert\NotBlank]
        public $airDate,

        #[Assert\Type(
            type: 'string',
            message: 'The code must be a {{ type }}.'
        )]
        #[Assert\Regex(
            pattern: '/^S\d{2}E\d{2}$/',
            message: 'The code "{{ value }}" is not valid. It should be in the format "SxxExx" where x is a digit.'
        )]
        #[Assert\NotBlank]
        public $code,

        #[Assert\Type(
            type: 'array',
            message: 'The characterIds  must be a {{ type }}.'
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
        #[Assert\NotBlank]
        public $characterIds
    )
    {
    }
}