<?php

namespace App\Managers\UrlGeneration;

use App\Contracts\Managers\UrlGeneration\UrlGenerateManagerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

readonly class UrlGenerateManager implements UrlGenerateManagerInterface
{
    public function __construct(
        private UrlGeneratorInterface $urlGenerator
    )
    {
    }

    /**
     * @param string $name
     * @param array $parameters
     * @param int $referenceType
     * @return string
     */
    public function generate(string $name, array $parameters = [], int $referenceType = self::ABSOLUTE_PATH): string
    {
        return $this->urlGenerator->generate($name, $parameters, $referenceType);
    }
}