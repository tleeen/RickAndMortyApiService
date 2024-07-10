<?php

namespace App\Repository\Location;

use App\Contracts\Managers\Pagination\PaginateManagerInterface;
use App\Contracts\Managers\UrlGeneration\UrlGenerateManagerInterface;
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
use App\Utils\Mappers\Out\Location\LocationDtoMapper;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @extends ServiceEntityRepository<Location>
 */
class LocationRepository extends ServiceEntityRepository implements LocationRepositoryInterface
{
    use HasFilter;

    public function __construct(
        ManagerRegistry                              $registry,
        private readonly PaginateManagerInterface    $paginatorManager,
        private readonly UrlGenerateManagerInterface $urlGenerator,
        private readonly SerializerInterface         $serializer
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

        return LocationDtoMapper::fromPaginator($this
            ->paginatorManager
            ->paginate($qb, $getLocationsDto->page ?: 1, $getLocationsDto->limit ?: 10),
            $this->urlGenerator);
    }

    /**
     * @param int $id
     * @return LocationDto
     */
    public function findById(int $id): LocationDto
    {
        return LocationDtoMapper::fromModel($this->find($id), $this->urlGenerator);
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

        $this->setAttributes($location, $this->serializer->normalize($createLocationDto));

        $this->getEntityManager()->persist($location);
        $this->getEntityManager()->flush();

        return LocationDtoMapper::fromModel($location, $this->urlGenerator);
    }

    /**
     * @param ChangeLocationDto $changeLocationDto
     * @return LocationDto
     */
    public function change(ChangeLocationDto $changeLocationDto): LocationDto
    {
        /** @var Location $location */
        $location = $this->find($changeLocationDto->id);

        $this->setAttributes($location, $this->serializer->normalize($changeLocationDto));

        $this->getEntityManager()->flush();

        return LocationDtoMapper::fromModel($location, $this->urlGenerator);
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

        $this->setAttributes($location, $this->serializer->normalize($updateLocationDto));

        $this->getEntityManager()->flush();

        return LocationDtoMapper::fromModel($location, $this->urlGenerator);
    }

    /**
     * @param Location $location
     * @param array $attributes
     * @return void
     */
    private function setAttributes(Location $location, array $attributes): void
    {
        if (isset($attributes['name'])) $location->setName($attributes['name']);
        if (isset($attributes['type'])) $location->setType($attributes['type']);
        if (isset($attributes['dimension'])) $location->setDimension($attributes['dimension']);
    }
}
