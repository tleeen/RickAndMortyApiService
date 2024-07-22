<?php

declare(strict_types=1);

namespace App\Contracts\Repositories\Location;

use App\DTO\In\Location\ChangeLocationDto;
use App\DTO\In\Location\CreateLocationDto;
use App\DTO\In\Location\GetLocationsDto;
use App\DTO\In\Location\UpdateLocationDto;
use App\DTO\Out\Location\LocationDto;
use App\DTO\Paginate\PaginateDto;
use App\Exceptions\Location\NotFoundLocationException;

interface LocationRepositoryInterface
{
    public function findMany(GetLocationsDto $getLocationsDto): PaginateDto;

    /**
     * @throws NotFoundLocationException
     */
    public function findById(int $id): LocationDto;

    /**
     * @throws NotFoundLocationException
     */
    public function delete(int $id): void;

    public function create(CreateLocationDto $createLocationDto): LocationDto;

    /**
     * @throws NotFoundLocationException
     */
    public function change(ChangeLocationDto $changeLocationDto): LocationDto;

    public function updateOrCreate(UpdateLocationDto $updateLocationDto): LocationDto;
}
