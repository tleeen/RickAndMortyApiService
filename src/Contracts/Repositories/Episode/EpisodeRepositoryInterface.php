<?php

declare(strict_types=1);

namespace App\Contracts\Repositories\Episode;

use App\DTO\In\Episode\ChangeEpisodeDto;
use App\DTO\In\Episode\CreateEpisodeDto;
use App\DTO\In\Episode\GetEpisodesDto;
use App\DTO\In\Episode\UpdateEpisodeDto;
use App\DTO\Out\Episode\EpisodeDto;
use App\DTO\Paginate\PaginateDto;
use App\Exceptions\Character\NotFoundCharacterException;
use App\Exceptions\Episode\NotFoundEpisodeException;

interface EpisodeRepositoryInterface
{
    public function findMany(GetEpisodesDto $getEpisodeDto): PaginateDto;

    /**
     * @throws NotFoundEpisodeException
     */
    public function findById(int $id): EpisodeDto;

    /**
     * @throws NotFoundEpisodeException
     */
    public function delete(int $id): void;

    /**
     * @throws NotFoundCharacterException
     */
    public function create(CreateEpisodeDto $createEpisodeDto): EpisodeDto;

    /**
     * @throws NotFoundCharacterException
     * @throws NotFoundEpisodeException
     */
    public function change(ChangeEpisodeDto $changeEpisodeDto): EpisodeDto;

    /**
     * @throws NotFoundCharacterException
     */
    public function updateOrCreate(UpdateEpisodeDto $updateEpisodeDto): EpisodeDto;
}
