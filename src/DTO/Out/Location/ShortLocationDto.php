<?php

namespace App\DTO\Out\Location;

use App\DTO\Utils\Enums\BaseUrl;
use App\DTO\Utils\Enums\Prefixes\BasePrefixes;
use App\DTO\Utils\Enums\Prefixes\ModulePrefixes;
use App\DTO\Utils\UrlMaker;
use App\Entity\Location;

class ShortLocationDto
{
    public readonly string $name;
    public readonly string $url;


    public function __construct(
        string $name,
        string $url
    )
    {
        $this->name = $name;
        $this->url = $url;
    }

    /**
     * @param Location $location
     * @return self
     */
    public static function fromModel(Location $location): self
    {
        return new self(
            name: $location->getName(),
            url: UrlMaker::makeUnique(BaseUrl::APP_URL->value
                , BasePrefixes::API->value
                , ModulePrefixes::LOCATIONS->value
                , $location->getId())
        );
    }
}