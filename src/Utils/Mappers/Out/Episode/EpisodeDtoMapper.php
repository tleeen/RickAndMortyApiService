<?php

namespace App\Utils\Mappers\Out\Episode;

use App\Contracts\Managers\UrlGeneration\UrlGenerateManagerInterface;
use App\DTO\Out\Episode\EpisodeDto;
use App\DTO\Paginate\PaginateDto;
use App\Entity\Episode;
use App\Managers\Pagination\PaginateManager as Paginator;
use App\Utils\Mappers\Paginate\PaginateDtoMapper;

class EpisodeDtoMapper
{
    /**
     * @param Episode $episode
     * @param UrlGenerateManagerInterface $urlGenerator
     * @return EpisodeDto
     */
    public static function fromModel(Episode $episode, UrlGenerateManagerInterface $urlGenerator): EpisodeDto
    {
        $episodeId = $episode->getId();

        return new EpisodeDto(
            id: $episodeId,
            name: $episode->getName(),
            air_date: $episode->getAirDate()->format('F j, Y'),
            episode: $episode->getCode(),
            characters: array_map(fn($character) => $urlGenerator->generate(
                'character_index',
                ['id' => $character->getId()],
                UrlGenerateManagerInterface::ABSOLUTE_URL), $episode->getCharacters()->toArray()),
            url: $urlGenerator->generate(
                'episode_index',
                ['id' => $episode->getId()],
                UrlGenerateManagerInterface::ABSOLUTE_URL),
            created: $episode->getCreatedAt()->format('Y-m-d\TH:i:s.v\Z')
        );
    }

    public static function fromPaginator(Paginator $paginator, UrlGenerateManagerInterface $urlGenerator): PaginateDto
    {
        return PaginateDtoMapper::fromPaginator($paginator,
            self::class,
            'episode',
            $urlGenerator);
    }
}