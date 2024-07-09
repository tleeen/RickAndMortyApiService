<?php

namespace App\Contracts\Managers\UrlGeneration;

interface UrlGenerateManagerInterface
{
    public const ABSOLUTE_URL = 0;
    public const ABSOLUTE_PATH = 1;
    public const RELATIVE_PATH = 2;
    public const NETWORK_PATH = 3;

    /**
     * @param string $name
     * @param array $parameters
     * @param int $referenceType
     * @return string
     */
    public function generate(string $name, array $parameters = [], int $referenceType = self::ABSOLUTE_PATH): string;
}