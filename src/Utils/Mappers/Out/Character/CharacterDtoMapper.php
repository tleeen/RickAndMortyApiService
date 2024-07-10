<?php

namespace App\Utils\Mappers\Out\Character;

use App\Contracts\Managers\UrlGeneration\UrlGenerateManagerInterface;
use App\DTO\Out\Character\CharacterDto;
use App\DTO\Paginate\PaginateDto;
use App\Entity\Character;
use App\Enums\Storage\StoragePath;
use App\Managers\Pagination\PaginateManager as Paginator;
use App\Utils\Mappers\Out\Location\ShortLocationDtoMapper;
use App\Utils\Mappers\Paginate\PaginateDtoMapper;

class CharacterDtoMapper
{
    /**
     * @param Character $character
     * @param UrlGenerateManagerInterface $urlGenerator
     * @return CharacterDto
     */
    public static function fromModel(Character $character, UrlGenerateManagerInterface $urlGenerator): CharacterDto
    {
        $characterId = $character->getId();

        return new CharacterDto(
            id: $characterId,
            name: $character->getName(),
            status: $character->getStatus(),
            species: $character->getSpecies(),
            type: $character->getType(),
            gender: $character->getGender(),
            origin: ShortLocationDtoMapper::fromModel($character->getOrigin(), $urlGenerator),
            location: ShortLocationDtoMapper::fromModel($character->getLastLocation(), $urlGenerator),
            image: $urlGenerator->generate('character_get')
            . StoragePath::CharacterAvatar->value
            . "/" . $character->getImage(),
            episode: array_map(fn($episode) => $urlGenerator->generate(
                'episode_index',
                ['id' => $episode->getId()],
                UrlGenerateManagerInterface::ABSOLUTE_URL)
                , $character->getEpisodes()->toArray()),
            url: $urlGenerator->generate(
                'character_index',
                ['id' => $characterId],
                UrlGenerateManagerInterface::ABSOLUTE_URL),
            created: $character->getCreatedAt()->format('Y-m-d\TH:i:s.v\Z')
        );
    }

    public static function fromPaginator(Paginator $paginator, UrlGenerateManagerInterface $urlGenerator): PaginateDto
    {
        return PaginateDtoMapper::fromPaginator(
            $paginator,
            self::class,
            'character',
            $urlGenerator);
    }
}