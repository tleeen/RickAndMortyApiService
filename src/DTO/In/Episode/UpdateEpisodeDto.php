<?php

namespace App\DTO\In\Episode;

use Symfony\Component\Validator\Constraints as Assert;

class UpdateEpisodeDto
{
    #[Assert\Type('integer')]
    #[Assert\NotBlank]
    #[Assert\Positive]
    public readonly int $id;

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
        int $id,
        string $name,
        string $airDate,
        string $code
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->airDate = $airDate;
        $this->code = $code;
    }
}