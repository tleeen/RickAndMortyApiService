<?php

namespace App\Contracts\Mappers\Out\Episode;

use App\DTO\Out\Episode\EpisodeDto;
use App\DTO\Paginate\PaginateDto;
use App\Entity\Episode;
use App\Managers\Pagination\PaginateManager as Paginator;

interface EpisodeDtoMapperInterface
{
    public function fromModel(Episode $episode): EpisodeDto;

    public function fromPaginator(Paginator $paginator): PaginateDto;
}