<?php

namespace App\Contracts\Repositories\Episode;

use App\DTO\In\Episode\ChangeEpisodeDto;
use App\DTO\In\Episode\CreateEpisodeDto;
use App\DTO\In\Episode\GetEpisodesDto;
use App\DTO\In\Episode\UpdateEpisodeDto;
use App\DTO\Out\Episode\EpisodeDto;
use App\DTO\Paginate\PaginateDto;

interface IEpisodeRepository
{
    /**
     * @param GetEpisodesDto $getEpisodeDto
     * @return PaginateDto
     */
    public function findMany(GetEpisodesDto $getEpisodeDto): PaginateDto;

    /**
     * @param int $id
     * @return EpisodeDto
     */
    public function findById(int $id): EpisodeDto;

    /**
     * @param int $id
     * @return void
     */
    public function delete(int $id): void;

    /**
     * @param CreateEpisodeDto $createEpisodeDto
     * @return EpisodeDto
     */
    public function create(CreateEpisodeDto $createEpisodeDto): EpisodeDto;

    /**
     * @param ChangeEpisodeDto $changeEpisodeDto
     * @return EpisodeDto
     */
    public function change(ChangeEpisodeDto $changeEpisodeDto): EpisodeDto;

    /**
     * @param UpdateEpisodeDto $updateEpisodeDto
     * @return EpisodeDto
     */
    public function updateOrCreate(UpdateEpisodeDto $updateEpisodeDto): EpisodeDto;
}