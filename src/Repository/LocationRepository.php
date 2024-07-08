<?php

namespace App\Repository;

use App\DTO\In\Location\ChangeLocationDto;
use App\DTO\In\Location\CreateLocationDto;
use App\DTO\In\Location\GetLocationsDto;
use App\DTO\In\Location\UpdateLocationDto;
use App\DTO\Out\Location\LocationDto;
use App\DTO\Paginate\PaginateDto;
use App\Entity\Location;
use App\Filter\Filters\Location\LocationFilterFactory;
use App\Filter\HasFilter;
use App\Managers\PaginatorManager;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Location>
 */
class LocationRepository extends ServiceEntityRepository
{
    use HasFilter;
    public function __construct(
        ManagerRegistry $registry,
        private readonly PaginatorManager $paginatorManager
    )
    {
        parent::__construct($registry, Location::class);
    }

    /**
     * @param GetLocationsDto $getLocationsDto
     * @return PaginateDto
     */
    public function findMany(GetLocationsDto $getLocationsDto): PaginateDto
    {
        $qb = $this->createQueryBuilder('location');

        $qb = $this->filterBy($qb, LocationFilterFactory::create($getLocationsDto->filters));

        if ($getLocationsDto->ids) {
            $qb->andWhere('location.id IN (:ids)')
                ->setParameter('ids', $getLocationsDto->ids);
        }

        return LocationDto::fromPaginator($this
            ->paginatorManager
            ->paginate($qb, $getLocationsDto->page ?: 1));
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

        $this->setAttributes($location, [
            'name' => $createLocationDto->name,
            'type' => $createLocationDto->type,
            'dimension' => $createLocationDto->dimension]);

        $this->getEntityManager()->persist($location);
        $this->getEntityManager()->flush();

        return LocationDto::fromModel($location);
    }

    /**
     * @param ChangeLocationDto $changeLocationDto
     * @return LocationDto
     */
    public function change(ChangeLocationDto $changeLocationDto): LocationDto
    {
        /** @var Location $location */
        $location = $this->find($changeLocationDto->id);

        $this->setAttributes($location, [
            'name' => $changeLocationDto->name,
            'type' => $changeLocationDto->type,
            'dimension' => $changeLocationDto->dimension]);

        $this->getEntityManager()->flush();

        return LocationDto::fromModel($location);
    }

    /**
     * @param UpdateLocationDto $updateLocationDto
     * @return LocationDto
     */
    public function updateOrCreate(UpdateLocationDto $updateLocationDto): LocationDto
    {
        /** @var Location $location */
        $location = $this->find($updateLocationDto->id);

        if (!$location) $location = new Location();

        $this->setAttributes($location, [
            'name' => $updateLocationDto->name,
            'type' => $updateLocationDto->type,
            'dimension' => $updateLocationDto->dimension]);

        $this->getEntityManager()->flush();

        return LocationDto::fromModel($location);
    }

    private function setAttributes(Location $location, array $attributes): void
    {
        if (isset($attributes['name'])) $location->setName($attributes['name']);
        if (isset($attributes['type'])) $location->setType($attributes['type']);
        if (isset($attributes['dimension'])) $location->setDimension($attributes['dimension']);
    }
}
