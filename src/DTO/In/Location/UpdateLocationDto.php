<?php

namespace App\DTO\In\Location;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * @property int $id
 * @property string $name
 * @property string $type
 * @property string $dimension
 */
class UpdateLocationDto
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

        #[Assert\Type(
            type: 'string',
            message: 'The type is not a valid {{ type }}.'
        )]
        #[Assert\NotBlank]
        public $type,

        #[Assert\Type(
            type: 'string',
            message: 'The dimension is not a valid {{ type }}.'
        )]
        #[Assert\NotBlank]
        public $dimension
    )
    {
    }
}