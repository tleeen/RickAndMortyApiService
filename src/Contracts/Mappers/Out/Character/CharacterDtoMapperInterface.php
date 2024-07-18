<?php

declare(strict_types=1);

namespace App\Contracts\Mappers\Out\Character;

use App\Contracts\Managers\Pagination\PaginateManagerInterface as Paginator;
use App\DTO\Out\Character\CharacterDto;
use App\DTO\Paginate\PaginateDto;
use App\Entity\Character;

interface CharacterDtoMapperInterface
{
    public function fromModel(Character $character): CharacterDto;

    public function fromPaginator(Paginator $paginator): PaginateDto;
}
