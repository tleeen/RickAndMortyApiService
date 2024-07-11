<?php

namespace App\Utils\Mappers\Out\Location;

use App\Contracts\Managers\UrlGeneration\UrlGenerateManagerInterface;
use App\Contracts\Mappers\Out\Location\ShortLocationDtoMapperInterface;
use App\DTO\Out\Location\ShortLocationDto;
use App\Entity\Location;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ShortLocationDtoMapper implements ShortLocationDtoMapperInterface
{
    public function __construct(
        private readonly UrlGeneratorInterface $urlGenerator,
    )
    {
    }

    public function fromModel(Location $location): ShortLocationDto
    {
        return new ShortLocationDto(
            name: $location->getName(),
            url: $this->urlGenerator->generate(
                'location_index',
                ['id' => $location->getId()],
                UrlGenerateManagerInterface::ABSOLUTE_URL
            )
        );
    }
}