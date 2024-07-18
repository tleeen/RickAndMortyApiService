<?php

declare(strict_types=1);

namespace App\Contracts\Repositories\Episode;

use App\DTO\In\Episode\ChangeEpisodeDto;
use App\DTO\In\Episode\CreateEpisodeDto;
use App\DTO\In\Episode\GetEpisodesDto;
use App\DTO\In\Episode\UpdateEpisodeDto;
use App\DTO\Out\Episode\EpisodeDto;
use App\DTO\Paginate\PaginateDto;

interface EpisodeRepositoryInterface
{
    public function findMany(GetEpisodesDto $getEpisodeDto): PaginateDto;

    public function findById(int $id): EpisodeDto;

    public function delete(int $id): void;

    public function create(CreateEpisodeDto $createEpisodeDto): EpisodeDto;

    public function change(ChangeEpisodeDto $changeEpisodeDto): EpisodeDto;

    public function updateOrCreate(UpdateEpisodeDto $updateEpisodeDto): EpisodeDto;
}
