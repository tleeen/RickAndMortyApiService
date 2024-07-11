<?php

namespace App\Utils\Mappers\Out\Episode;

use App\Contracts\Managers\UrlGeneration\UrlGenerateManagerInterface;
use App\Contracts\Mappers\Out\Episode\EpisodeDtoMapperInterface;
use App\Contracts\Mappers\Paginate\PaginateDtoMapperInterface;
use App\DTO\Out\Episode\EpisodeDto;
use App\DTO\Paginate\PaginateDto;
use App\Entity\Episode;
use App\Managers\Pagination\PaginateManager as Paginator;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class EpisodeDtoMapper implements EpisodeDtoMapperInterface
{
    public function __construct(
        private readonly UrlGeneratorInterface $urlGenerator,
        private readonly PaginateDtoMapperInterface $paginateDtoMapper
    )
    {
    }

    public function fromModel(Episode $episode): EpisodeDto
    {
        $episodeId = $episode->getId();

        return new EpisodeDto(
            id: $episodeId,
            name: $episode->getName(),
            air_date: $episode->getAirDate()->format('F j, Y'),
            episode: $episode->getCode(),
            characters: array_map(
                fn($character) => $this->urlGenerator->generate(
                'character_index',
                ['id' => $character->getId()],
                UrlGenerateManagerInterface::ABSOLUTE_URL
                ),
                $episode->getCharacters()->toArray()
            ),
            url: $this->urlGenerator->generate(
                'episode_index',
                ['id' => $episode->getId()],
                UrlGenerateManagerInterface::ABSOLUTE_URL
            ),
            created: $episode->getCreatedAt()->format('Y-m-d\TH:i:s.v\Z')
        );
    }

    public function fromPaginator(Paginator $paginator): PaginateDto
    {
        return $this->paginateDtoMapper->fromPaginator(
            $paginator,
            $this,
            'episode'
        );
    }
}