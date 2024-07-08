<?php

namespace App\DTO\In\Episode;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class FilterDto
{
    #[Assert\Type('string')]
    public readonly ?string $name;

    #[Assert\Type('string')]
    #[Assert\Regex(
        pattern: '/^S\d{2}E\d{2}$/',
    )]
    public readonly ?string $code;

    public function __construct(
        ?string $name,
        ?string $code
    )
    {
        $this->name = $name;
       $this->code = $code;
    }

    /**
     * @param Request $request
     * @return self
     */
    public static function fromRequest(Request $request): self
    {
        return new self(
            name: $request->query->get('name') ?? null,
            code: $request->query->get('code') ?? null
        );
    }
}