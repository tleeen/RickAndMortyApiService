<?php

declare(strict_types=1);

namespace App\Contracts\Mappers\Out\Episode;

use App\Contracts\Managers\Pagination\PaginateManagerInterface as Paginator;
use App\DTO\Out\Episode\EpisodeDto;
use App\DTO\Paginate\PaginateDto;
use App\Entity\Episode;

interface EpisodeDtoMapperInterface
{
    public function fromModel(Episode $episode): EpisodeDto;

    public function fromPaginator(Paginator $paginator): PaginateDto;
}
