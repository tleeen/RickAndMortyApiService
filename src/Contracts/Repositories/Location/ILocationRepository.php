<?php

namespace App\Contracts\Repositories\Location;

use App\DTO\In\Location\ChangeLocationDto;
use App\DTO\In\Location\CreateLocationDto;
use App\DTO\In\Location\GetLocationsDto;
use App\DTO\In\Location\UpdateLocationDto;
use App\DTO\Out\Location\LocationDto;
use App\DTO\Paginate\PaginateDto;

interface ILocationRepository
{
    /**
     * @param GetLocationsDto $getLocationsDto
     * @return PaginateDto
     */
    public function findMany(GetLocationsDto $getLocationsDto): PaginateDto;

    /**
     * @param int $id
     * @return LocationDto
     */
    public function findById(int $id): LocationDto;

    /**
     * @param int $id
     * @return void
     */
    public function delete(int $id): void;

    /**
     * @param CreateLocationDto $createLocationDto
     * @return LocationDto
     */
    public function create(CreateLocationDto $createLocationDto): LocationDto;

    /**
     * @param ChangeLocationDto $changeLocationDto
     * @return LocationDto
     */
    public function change(ChangeLocationDto $changeLocationDto): LocationDto;

    /**
     * @param UpdateLocationDto $updateLocationDto
     * @return LocationDto
     */
    public function updateOrCreate(UpdateLocationDto $updateLocationDto): LocationDto;
}