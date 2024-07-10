<?php

namespace App\DTO\In\Episode;

use Symfony\Component\Validator\Constraints as Assert;

readonly class FilterDto
{
    #[Assert\Type('string')]
    public ?string $name;

    #[Assert\Type('string')]
    #[Assert\Regex(
        pattern: '/^S\d{2}E\d{2}$/',
    )]
    public ?string $code;

    public function __construct(
        ?string $name,
        ?string $code
    )
    {
        $this->name = $name;
       $this->code = $code;
    }
}