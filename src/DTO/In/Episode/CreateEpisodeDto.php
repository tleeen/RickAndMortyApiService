<?php

namespace App\DTO\In\Episode;

use Symfony\Component\HttpFoundation\Request;
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

    /**
     * @param Request $request
     * @return self
     */
    public static function fromRequest(Request $request): self
    {
        $episode = $request->toArray();
        return new self(
            name: $episode['name'],
            airDate: $episode['airDate'],
            code: $episode['code']
        );
    }
}