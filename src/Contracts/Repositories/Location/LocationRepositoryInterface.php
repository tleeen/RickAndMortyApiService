<?php

declare(strict_types=1);

namespace App\Contracts\Repositories\Location;

use App\DTO\In\Location\ChangeLocationDto;
use App\DTO\In\Location\CreateLocationDto;
use App\DTO\In\Location\GetLocationsDto;
use App\DTO\In\Location\UpdateLocationDto;
use App\DTO\Out\Location\LocationDto;
use App\DTO\Paginate\PaginateDto;
use App\Exceptions\Location\NotFoundLocation;

interface LocationRepositoryInterface
{
    public function findMany(GetLocationsDto $getLocationsDto): PaginateDto;

    /**
     * @throws NotFoundLocation
     */
    public function findById(int $id): LocationDto;

    /**
     * @throws NotFoundLocation
     */
    public function delete(int $id): void;

    public function create(CreateLocationDto $createLocationDto): LocationDto;

    /**
     * @throws NotFoundLocation
     */
    public function change(ChangeLocationDto $changeLocationDto): LocationDto;

    public function updateOrCreate(UpdateLocationDto $updateLocationDto): LocationDto;
}
