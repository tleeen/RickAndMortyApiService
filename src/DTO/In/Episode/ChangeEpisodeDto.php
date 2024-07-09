<?php

namespace App\DTO\In\Episode;

use Symfony\Component\Validator\Constraints as Assert;

class ChangeEpisodeDto
{
    #[Assert\Type('integer')]
    #[Assert\NotBlank]
    #[Assert\Positive]
    public readonly int $id;

    #[Assert\Type('string')]
    public readonly ?string $name;

    #[Assert\Date]
    public readonly ?string $airDate;

    #[Assert\Type('string')]
    #[Assert\Regex(
        pattern: '/^S\d{2}E\d{2}$/',
    )]
    public readonly ?string $code;

    public function __construct(
        int $id,
        ?string $name,
        ?string $airDate,
        ?string $code
    )
    {
        $this->id = $id;
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
            id: $request->get('id'),
            name: $episode['name'] ?? null,
            airDate: $episode['airDate'] ?? null,
            code: $episode['code'] ?? null
        );
    }
}