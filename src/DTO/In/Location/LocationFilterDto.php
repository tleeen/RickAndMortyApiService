<?php

namespace App\DTO\In\Location;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * @property string|null $name
 * @property string|null $type
 * @property string|null $dimension
 */
class LocationFilterDto
{
    public function __construct(
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
            message: 'The type is not a valid {{ type }} or null.'
        )]
        /**
         * @var string|null
         */
        public $type,

        #[Assert\Type(
            type: 'string',
            message: 'The dimension is not a valid {{ type }} or null.'
        )]
        /**
         * @var string|null
         */
        public $dimension
    )
    {
    }
}