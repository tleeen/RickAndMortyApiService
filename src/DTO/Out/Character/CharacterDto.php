<?php

namespace App\DTO\Out\Character;

use App\DTO\Enums\BaseUrl;
use App\DTO\Enums\Prefixes\BasePrefixes;
use App\DTO\Enums\Prefixes\ModulePrefixes;
use App\DTO\Out\Location\ShortLocationDto;
use App\DTO\Utils\UrlMaker;
use App\Entity\Character;

class CharacterDto
{
    public readonly int $id;
    public readonly string $name;
    public readonly string $status;
    public readonly string $species;
    public readonly ?string $type;
    public readonly string $gender;
    public readonly ShortLocationDto $origin;
    public readonly ShortLocationDto $location;
    public readonly string $image;
    public readonly array $episode;
    public readonly string $url;
    public readonly string $created;


    public function __construct(
        int    $id,
        string  $name,
        string  $status,
        string  $species,
        ?string $type,
        string  $gender,
        ShortLocationDto $origin,
        ShortLocationDto $location,
        string $image,
        array $episode,
        string $url,
        string $created
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->status = $status;
        $this->species = $species;
        $this->type = $type;
        $this->gender = $gender;
        $this->origin = $origin;
        $this->location = $location;
        $this->image = $image;
        $this->episode = $episode;
        $this->url = $url;
        $this->created = $created;
    }

    /**
     * @param Character $character
     * @return self
     */
    public static function fromModel(Character $character): self
    {
        $characterId = $character->getId();

        return new self(
            id: $characterId,
            name: $character->getName(),
            status: $character->getStatus(),
            species: $character->getSpecies(),
            type: $character->getType(),
            gender: $character->getGender(),
            origin: ShortLocationDto::fromModel($character->getOrigin()),
            location: ShortLocationDto::fromModel($character->getLastLocation()),
            image: UrlMaker::makeStoreImage(BaseUrl::APP_URL->value
                , BasePrefixes::API->value
                , ModulePrefixes::CHARACTERS->value
                , $character->getImage()),
            episode: array_map(fn($episode) => UrlMaker::makeUnique(BaseUrl::APP_URL->value
                , BasePrefixes::API->value
                , ModulePrefixes::EPISODES->value
                , $episode->getId()), $character->getEpisodes()->toArray()),
            url: UrlMaker::makeUnique(BaseUrl::APP_URL->value
                , BasePrefixes::API->value
                , ModulePrefixes::CHARACTERS->value
                , $characterId),
            created: $character->getCreatedAt()->format('Y-m-d\TH:i:s.v\Z')
        );
    }
}