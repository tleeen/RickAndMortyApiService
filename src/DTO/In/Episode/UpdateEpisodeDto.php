<?php

namespace App\DTO\In\Episode;

use Symfony\Component\Validator\Constraints as Assert;

readonly class UpdateEpisodeDto
{
    #[Assert\Type('integer')]
    #[Assert\NotBlank]
    #[Assert\Positive]
    public int $id;

    #[Assert\Type('string')]
    #[Assert\NotBlank]
    public string $name;

    #[Assert\Date]
    #[Assert\NotBlank]
    public string $airDate;

    #[Assert\Type('string')]
    #[Assert\NotBlank]
    #[Assert\Regex(
        pattern: '/^S\d{2}E\d{2}$/',
    )]
    public string $code;

    #[Assert\Type('array')]
    #[Assert\NotBlank]
    public array $characterIds;

    public function __construct(
        int $id,
        string $name,
        string $airDate,
        string $code,
        array $characterIds
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->airDate = $airDate;
        $this->code = $code;
        $this->characterIds = $characterIds;
    }
}