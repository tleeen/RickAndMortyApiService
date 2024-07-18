<?php

declare(strict_types=1);

namespace App\Repository\Location;

use App\Contracts\Managers\Pagination\PaginateManagerInterface;
use App\Contracts\Mappers\Out\Location\LocationDtoMapperInterface;
use App\Contracts\Repositories\Location\LocationRepositoryInterface;
use App\DTO\In\Location\ChangeLocationDto;
use App\DTO\In\Location\CreateLocationDto;
use App\DTO\In\Location\GetLocationsDto;
use App\DTO\In\Location\UpdateLocationDto;
use App\DTO\Out\Location\LocationDto;
use App\DTO\Paginate\PaginateDto;
use App\Entity\Location;
use App\Filter\Filters\Location\LocationFilterFactory;
use App\Filter\HasFilter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Location>
 */
class LocationRepository extends ServiceEntityRepository implements LocationRepositoryInterface
{
    use HasFilter;

    public function __construct(
        ManagerRegistry                              $registry,
        private readonly PaginateManagerInterface    $paginatorManager,
        private readonly LocationDtoMapperInterface $locationDtoMapper,
    )
    {
        parent::__construct($registry, Location::class);
    }

    public function findMany(GetLocationsDto $getLocationsDto): PaginateDto
    {
        $queryBuilder = $this->createQueryBuilder('location');

        $queryBuilder = $this->filterBy($queryBuilder, LocationFilterFactory::create($getLocationsDto->filters));

        if (isset($getLocationsDto->ids)) {
            $queryBuilder->andWhere('location.id IN (:ids)')
                ->setParameter('ids', $getLocationsDto->ids);
        }

        return $this->locationDtoMapper->fromPaginator($this
            ->paginatorManager
            ->paginate($queryBuilder, $getLocationsDto->page, $getLocationsDto->limit),
            );
    }

    public function findById(int $id): LocationDto
    {
        return $this->locationDtoMapper->fromModel($this->find($id));
    }

    public function delete(int $id): void
    {
        $this->getEntityManager()->remove($this->find($id));
        $this->getEntityManager()->flush();
    }

    public function create(CreateLocationDto $createLocationDto): LocationDto
    {
        $location = new Location();
        $this->setAttributes($location, $createLocationDto);
        $this->getEntityManager()->persist($location);
        $this->getEntityManager()->flush();
        return $this->locationDtoMapper->fromModel($location);
    }

    public function change(ChangeLocationDto $changeLocationDto): LocationDto
    {
        $location = $this->find($changeLocationDto->id);
        $this->setAttributes($location, $changeLocationDto);
        $this->getEntityManager()->flush();
        return $this->locationDtoMapper->fromModel($location);
    }

    public function updateOrCreate(UpdateLocationDto $updateLocationDto): LocationDto
    {
        $location = $this->find($updateLocationDto->id);
        if (!$location) $location = new Location();
        $this->setAttributes($location, $updateLocationDto);
        $this->getEntityManager()->flush();
        return $this->locationDtoMapper->fromModel($location);
    }

    private function setAttributes(
        Location $location,
        UpdateLocationDto|CreateLocationDto|ChangeLocationDto $locationDto
    ): void
    {
        if (isset($locationDto->name)) $location->setName($locationDto->name);
        if (isset($locationDto->type)) $location->setType($locationDto->type);
        if (isset($locationDto->dimension)) $location->setDimension($locationDto->dimension);
    }
}
