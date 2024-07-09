<?php

namespace App\Utils\Mappers\Out\Location;

use App\Contracts\Managers\UrlGeneration\UrlGenerateManagerInterface;
use App\DTO\Out\Location\ShortLocationDto;
use App\Entity\Location;

class ShortLocationDtoMapper
{
    /**
     * @param Location $location
     * @param UrlGenerateManagerInterface $urlGenerator
     * @return ShortLocationDto
     */
    public static function fromModel(Location $location, UrlGenerateManagerInterface $urlGenerator): ShortLocationDto
    {
        return new ShortLocationDto(
            name: $location->getName(),
            url: $urlGenerator->generate(
                'location_index',
                ['id' => $location->getId()],
            UrlGenerateManagerInterface::ABSOLUTE_URL)
        );
    }
}