<?php

namespace App\DTO\Out\Episode;

use App\DTO\Paginate\PaginateDto;
use App\DTO\Utils\Enums\BaseUrl;
use App\DTO\Utils\Enums\Prefixes\BasePrefixes;
use App\DTO\Utils\Enums\Prefixes\ModulePrefixes;
use App\DTO\Utils\UrlMaker;
use App\Entity\Episode;
use App\Managers\Pagination\PaginateManager as Paginator;

class EpisodeDto
{
    public readonly int $id;
    public readonly string $name;
    public readonly string $air_date;
    public readonly string $episode;
    public readonly array $characters;
    public readonly string $url;
    public readonly string $created;


    public function __construct(
        int    $id,
        string $name,
        string $air_date,
        string $episode,
        array  $characters,
        string $url,
        string $created,
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->air_date = $air_date;
        $this->episode = $episode;
        $this->characters = $characters;
        $this->url = $url;
        $this->created = $created;
    }

    /**
     * @param Episode $episode
     * @return self
     */
    public static function fromModel(Episode $episode): self
    {
        $episodeId = $episode->getId();

        return new self(
            id: $episodeId,
            name: $episode->getName(),
            air_date: $episode->getAirDate()->format('F j, Y'),
            episode: $episode->getCode(),
            characters: array_map(fn($character) => UrlMaker::makeUnique(BaseUrl::APP_URL->value
                , BasePrefixes::API->value
                , ModulePrefixes::CHARACTERS->value
                , $character->getId()), $episode->getCharacters()->toArray()),
            url: UrlMaker::makeUnique(BaseUrl::APP_URL->value
                , BasePrefixes::API->value
                , ModulePrefixes::EPISODES->value
                , $episodeId),
            created: $episode->getCreatedAt()->format('Y-m-d\TH:i:s.v\Z')
        );
    }

    public static function fromPaginator(Paginator $paginator): PaginateDto
    {
        return PaginateDto::fromPaginator($paginator,
            self::class,
            ModulePrefixes::EPISODES->value);
    }
}