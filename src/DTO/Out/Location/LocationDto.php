<?php

namespace App\DTO\Out\Location;

use App\DTO\Enums\BaseUrl;
use App\DTO\Enums\Prefixes\BasePrefixes;
use App\DTO\Enums\Prefixes\ModulePrefixes;
use App\DTO\Utils\UrlMaker;
use App\Entity\Location;

class LocationDto
{
    public readonly int $id;
    public readonly string $name;
    public readonly string $type;
    public readonly string $dimension;
    public readonly array $residents;
    public readonly string $url;
    public readonly string $created;


    public function __construct(
        int    $id,
        string $name,
        string $type,
        string $dimension,
        array  $residents,
        string $url,
        string $created,

    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->type = $type;
        $this->dimension = $dimension;
        $this->residents = $residents;
        $this->url = $url;
        $this->created = $created;
    }

    /**
     * @param Location $location
     * @return self
     */
    public static function fromModel(Location $location): self
    {
        $locationId = $location->getId();

        return new self(
            id: $locationId,
            name: $location->getName(),
            type: $location->getType(),
            dimension: $location->getDimension(),
            residents: array_map(fn($resident) => UrlMaker::makeUnique(BaseUrl::APP_URL->value
                , BasePrefixes::API->value
                , ModulePrefixes::CHARACTERS->value
                , $resident->getId()), $location->getResidents()->toArray()),
            url: UrlMaker::makeUnique(BaseUrl::APP_URL->value
                , BasePrefixes::API->value
                , ModulePrefixes::LOCATIONS->value
                , $locationId),
            created: $location->getCreatedAt()->format('Y-m-d\TH:i:s.v\Z')
        );
    }
}