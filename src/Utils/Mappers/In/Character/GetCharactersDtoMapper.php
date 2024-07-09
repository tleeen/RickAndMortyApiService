<?php

namespace App\Utils\Mappers\In\Character;

use App\DTO\In\Character\GetCharactersDto;
use Symfony\Component\HttpFoundation\Request;

class GetCharactersDtoMapper
{
    /**
     * @param Request $request
     * @return GetCharactersDto
     */
    public static function fromRequest(Request $request): GetCharactersDto
    {
        return new GetCharactersDto(
            ids: array_map(fn($id) => (int)$id, $request->query->all('ids')),
            page: $request->query->get('page'),
            limit: $request->query->get('limit'),
            filters: FilterDtoMapper::fromRequest($request),
        );
    }
}