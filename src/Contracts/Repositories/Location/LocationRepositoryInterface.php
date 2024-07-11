<?php

namespace App\Contracts\Repositories\Location;

use App\DTO\In\Location\ChangeLocationDto;
use App\DTO\In\Location\CreateLocationDto;
use App\DTO\In\Location\GetLocationsDto;
use App\DTO\In\Location\UpdateLocationDto;
use App\DTO\Out\Location\LocationDto;
use App\DTO\Paginate\PaginateDto;

interface LocationRepositoryInterface
{
    public function findMany(GetLocationsDto $getLocationsDto): PaginateDto;

    public function findById(int $id): LocationDto;

    public function delete(int $id): void;

    public function create(CreateLocationDto $createLocationDto): LocationDto;

    public function change(ChangeLocationDto $changeLocationDto): LocationDto;

    public function updateOrCreate(UpdateLocationDto $updateLocationDto): LocationDto;
}