<?php

declare(strict_types=1);

namespace App\Utils\Mappers\Out\Character;

use App\Contracts\Mappers\Out\Character\CharacterDtoMapperInterface;
use App\Contracts\Mappers\Out\Location\ShortLocationDtoMapperInterface;
use App\Contracts\Mappers\Paginate\PaginateDtoMapperInterface;
use App\DTO\Out\Character\CharacterDto;
use App\DTO\Paginate\PaginateDto;
use App\Entity\Character;
use App\Enums\Storage\StoragePath;
use App\Managers\Pagination\PaginateManager as Paginator;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

readonly class CharacterDtoMapper implements CharacterDtoMapperInterface
{
    public function __construct(
        private ShortLocationDtoMapperInterface $shortLocationDtoMapper,
        private UrlGeneratorInterface $urlGenerator,
        private PaginateDtoMapperInterface $paginateDtoMapper
    ) {
    }

    public function fromModel(Character $character): CharacterDto
    {
        $characterId = $character->getId();

        return new CharacterDto(
            id: $characterId,
            name: $character->getName(),
            status: $character->getStatus(),
            species: $character->getSpecies(),
            type: $character->getType(),
            gender: $character->getGender(),
            origin: $this->shortLocationDtoMapper->fromModel($character->getOrigin()),
            location: $this->shortLocationDtoMapper->fromModel($character->getLastLocation()),
            image: $this->urlGenerator->generate('character_get')
            .StoragePath::CharacterAvatar->value
            .'/'.$character->getImage(),
            episode: array_map(
                fn ($episode) => $this->urlGenerator->generate(
                    'episode_index',
                    ['id' => $episode->getId()],
                    UrlGeneratorInterface::ABSOLUTE_URL
                ),
                $character->getEpisodes()->toArray()
            ),
            url: $this->urlGenerator->generate(
                'character_index',
                ['id' => $characterId],
                UrlGeneratorInterface::ABSOLUTE_URL
            ),
            created: $character->getCreatedAt()->format('Y-m-d\TH:i:s.v\Z')
        );
    }

    public function fromPaginator(Paginator $paginator): PaginateDto
    {
        return $this->paginateDtoMapper->fromPaginator(
            $paginator,
            $this,
            'character'
        );
    }
}
