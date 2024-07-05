<?php

namespace App\Repository;

use App\DTO\Collection\CollectionDto;
use App\DTO\In\Location\CreateLocationDto;
use App\DTO\In\Location\UpdateLocationDto;
use App\DTO\Out\Location\LocationDto;
use App\Entity\Location;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Location>
 */
class LocationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Location::class);
    }

    /**
     * @param $getLocationsDto
     * @return CollectionDto
     */
    public function findMany($getLocationsDto): CollectionDto
    {
        if (empty($getLocationsDto->ids)) {
            return CollectionDto::fromArray(
                $this->findAll(),
                LocationDto::class);
        } else {
            return CollectionDto::fromArray(
                $this->findBy(['id' => $getLocationsDto->ids]),
                LocationDto::class);
        }
    }

    /**
     * @param int $id
     * @return LocationDto
     */
    public function findById(int $id): LocationDto
    {
        return LocationDto::fromModel($this->find($id));
    }

    /**
     * @param int $id
     * @return void
     */
    public function delete(int $id): void
    {
        $this->getEntityManager()->remove($this->find($id));
        $this->getEntityManager()->flush();
    }

    /**
     * @param CreateLocationDto $createLocationDto
     * @return LocationDto
     */
    public function create(CreateLocationDto $createLocationDto): LocationDto
    {
        $location = new Location();

        $location->setName($createLocationDto->name);
        $location->setType($createLocationDto->type);
        $location->setDimension($createLocationDto->dimension);

        $this->getEntityManager()->persist($location);
        $this->getEntityManager()->flush();

        return LocationDto::fromModel($location);
    }

    /**
     * @param UpdateLocationDto $updateLocationDto
     * @return LocationDto
     */
    public function change(UpdateLocationDto $updateLocationDto): LocationDto
    {
        /** @var Location $location */
        $location = $this->find($updateLocationDto->id);

        if ($updateLocationDto->name) {
            $location->setName($updateLocationDto->name);
        }
        if ($updateLocationDto->type) {
            $location->setType($updateLocationDto->type);
        }
        if ($updateLocationDto->dimension) {
            $location->setDimension($updateLocationDto->dimension);
        }

        $this->getEntityManager()->flush();

        return LocationDto::fromModel($location);
    }
}
