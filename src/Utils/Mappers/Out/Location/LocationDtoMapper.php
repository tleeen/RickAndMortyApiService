<?php

namespace App\Utils\Mappers\Out\Location;

use App\Contracts\Managers\UrlGeneration\UrlGenerateManagerInterface;
use App\Contracts\Mappers\Out\Location\LocationDtoMapperInterface;
use App\Contracts\Mappers\Paginate\PaginateDtoMapperInterface;
use App\DTO\Out\Location\LocationDto;
use App\DTO\Paginate\PaginateDto;
use App\Entity\Location;
use App\Managers\Pagination\PaginateManager as Paginator;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class LocationDtoMapper implements LocationDtoMapperInterface
{
    public function __construct(
        private readonly UrlGeneratorInterface $urlGenerator,
        private readonly PaginateDtoMapperInterface $paginateDtoMapper
    )
    {
    }

    public function fromModel(Location $location): LocationDto
    {
        $locationId = $location->getId();

        return new LocationDto(
            id: $locationId,
            name: $location->getName(),
            type: $location->getType(),
            dimension: $location->getDimension(),
            residents: array_map(
                fn($resident) => $this->urlGenerator->generate(
                'character_index',
                ['id' => $resident->getId()],
                UrlGenerateManagerInterface::ABSOLUTE_URL
                ),
                $location->getResidents()->toArray()
            ),
            url: $this->urlGenerator->generate(
                'location_index',
                ['id' => $locationId],
                UrlGenerateManagerInterface::ABSOLUTE_URL
            ),
            created: $location->getCreatedAt()->format('Y-m-d\TH:i:s.v\Z')
        );
    }

    public function fromPaginator(Paginator $paginator): PaginateDto
    {
        return $this->paginateDtoMapper->fromPaginator(
            $paginator,
            $this,
            'location'
        );
    }
}