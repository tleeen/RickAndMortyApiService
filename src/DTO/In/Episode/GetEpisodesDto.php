<?php

namespace App\DTO\In\Episode;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * @property array|null $ids
 * @property int|null $page
 * @property int|null $limit
 * @property EpisodeFilterDto $filters
 */
class GetEpisodesDto
{
    public function __construct(
        #[Assert\Type(
            type: 'array',
            message: 'The ids  must be a {{ type }} or null.'
        )]
        #[Assert\All([
            new Assert\Type([
                'type' => 'integer',
                'message' => 'The ids item is not a valid integer.'
            ]),
            new Assert\Positive([
                'message' => 'The ids item is not a positive.'
            ])
        ])]
        public $ids,

        #[Assert\Type(
            type: 'integer',
            message: 'The page is not a valid {{ type }} or null.'
        )]
        #[Assert\PositiveOrZero(
            message: 'The page is not a positive.'
        )]
        public $page,

        #[Assert\Type(
            type: 'integer',
            message: 'The limit is not a valid {{ type }} or null.'
        )]
        #[Assert\PositiveOrZero(
            message: 'The limit is not a positive.'
        )]
        #[Assert\LessThanOrEqual(
            value: 20,
            message: 'The limit should be less than or equal to {{ compared_value }}.'
        )]
        public $limit,

        #[Assert\Valid]
        public $filters
    )
    {
    }
}