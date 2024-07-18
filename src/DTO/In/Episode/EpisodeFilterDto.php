<?php

declare(strict_types=1);

namespace App\DTO\In\Episode;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * @property string|null $name
 * @property string|null $code
 */
class EpisodeFilterDto
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
            message: 'The code must be a {{ type }} or null.'
        )]
        #[Assert\Regex(
            pattern: '/^S\d{2}E\d{2}$/',
            message: 'The code "{{ value }}" is not valid. It should be in the format "SxxExx" where x is a digit.'
        )]
        /**
         * @var string|null
         */
        public $code
    ) {
    }
}
