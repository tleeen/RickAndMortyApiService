<?php

declare(strict_types=1);

namespace App\Utils\Mappers\In\Character;

use App\Contracts\Mappers\In\Character\CharacterFilterDtoMapperInterface;
use App\Contracts\Mappers\In\Character\GetCharactersDtoMapperInterface;
use App\DTO\In\Character\GetCharactersDto;
use Symfony\Component\HttpFoundation\Request;

class GetCharactersDtoMapper implements GetCharactersDtoMapperInterface
{
    public function __construct(
        private readonly CharacterFilterDtoMapperInterface $filterDtoMapper,
    )
    {
    }

    public function fromRequest(Request $request): GetCharactersDto
    {
        return new GetCharactersDto(
            ids: array_map(fn($id) => (int) $id, $request->query->all('ids')) ?: null,
            page: (int) $request->query->get('page') ?: null,
            limit: (int) $request->query->get('limit') ?: null,
            filters: $this->filterDtoMapper->fromRequest($request),
        );
    }
}