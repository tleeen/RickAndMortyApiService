<?php

namespace App\DTO\In\Episode;

use Symfony\Component\Validator\Constraints as Assert;

class CreateEpisodeDto
{
    #[Assert\Type('string')]
    #[Assert\NotBlank]
    public readonly string $name;

    #[Assert\Date]
    #[Assert\NotBlank]
    public readonly string $airDate;

    #[Assert\Type('string')]
    #[Assert\NotBlank]
    #[Assert\Regex(
        pattern: '/^S\d{2}E\d{2}$/',
    )]
    public readonly string $code;

    public function __construct(
        string $name,
        string $airDate,
        string $code
    )
    {
        $this->name = $name;
        $this->airDate = $airDate;
        $this->code = $code;
    }
}