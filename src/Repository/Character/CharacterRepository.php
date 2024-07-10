<?php

namespace App\Repository\Character;

use App\Contracts\Managers\Pagination\PaginateManagerInterface;
use App\Contracts\Managers\UrlGeneration\UrlGenerateManagerInterface;
use App\Contracts\Repositories\Character\CharacterRepositoryInterface;
use App\DTO\In\Character\ChangeCharacterDto;
use App\DTO\In\Character\CreateCharacterDto;
use App\DTO\In\Character\GetCharactersDto;
use App\DTO\In\Character\UpdateCharacterDto;
use App\DTO\Out\Character\CharacterDto;
use App\DTO\Paginate\PaginateDto;
use App\Entity\Character;
use App\Entity\Location;
use App\Filter\Filters\Character\CharacterFilterFactory;
use App\Filter\HasFilter;
use App\Utils\Mappers\Out\Character\CharacterDtoMapper;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @extends ServiceEntityRepository<Character>
 */
class CharacterRepository extends ServiceEntityRepository implements CharacterRepositoryInterface
{
    use HasFilter;

    public function __construct(
        ManagerRegistry                              $registry,
        private readonly PaginateManagerInterface    $paginatorManager,
        private readonly UrlGenerateManagerInterface $urlGenerator,
        private readonly SerializerInterface         $serializer
    )
    {
        parent::__construct($registry, Character::class);
    }

    /**
     * @param GetCharactersDto $getCharactersDto
     * @return PaginateDto
     */
    public function findMany(GetCharactersDto $getCharactersDto): PaginateDto
    {
        $qb = $this->createQueryBuilder('character');

        $qb = $this->filterBy($qb, CharacterFilterFactory::create($getCharactersDto->filters));

        if ($getCharactersDto->ids) {
            $qb->andWhere('character.id IN (:ids)')
                ->setParameter('ids', $getCharactersDto->ids);
        }

        return CharacterDtoMapper::fromPaginator($this
            ->paginatorManager
            ->paginate($qb, $getCharactersDto->page ?: 1, $getCharactersDto->limit ?: 10),
            $this->urlGenerator);
    }

    /**
     * @param int $id
     * @return CharacterDto
     */
    public function findById(int $id): CharacterDto
    {
        return CharacterDtoMapper::fromModel($this->find($id), $this->urlGenerator);
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
     * @param CreateCharacterDto $createCharacterDto
     * @return CharacterDto
     * @throws ORMException
     */
    public function create(CreateCharacterDto $createCharacterDto): CharacterDto
    {
        $character = new Character();

        $this->setAttributes($character, $this->serializer->normalize($createCharacterDto));

        $this->getEntityManager()->persist($character);
        $this->getEntityManager()->flush();

        return CharacterDtoMapper::fromModel($character, $this->urlGenerator);
    }

    /**
     * @param ChangeCharacterDto $changeCharacterDto
     * @return CharacterDto
     * @throws ORMException
     */
    public function change(ChangeCharacterDto $changeCharacterDto): CharacterDto
    {
        /** @var Character $character */
        $character = $this->find($changeCharacterDto->id);

        $this->setAttributes($character, $this->serializer->normalize($changeCharacterDto));

        $this->getEntityManager()->flush();

        return CharacterDtoMapper::fromModel($character, $this->urlGenerator);
    }

    /**
     * @param UpdateCharacterDto $updateCharacterDto
     * @return CharacterDto
     * @throws ORMException
     */
    public function updateOrCreate(UpdateCharacterDto $updateCharacterDto): CharacterDto
    {
        /** @var Character $character */
        $character = $this->find($updateCharacterDto->id);

        if (!$character) $character = new Character();

        $this->setAttributes($character, $this->serializer->normalize($updateCharacterDto));

        $this->getEntityManager()->flush();

        return CharacterDtoMapper::fromModel($character, $this->urlGenerator);
    }

    /**
     * @param Character $character
     * @param array $attributes
     * @return void
     * @throws ORMException
     */
    private function setAttributes(Character $character, array $attributes): void
    {
        $em = $this->getEntityManager();

        if (isset($attributes['name'])) $character->setName($attributes['name']);
        if (isset($attributes['status'])) $character->setStatus($attributes['status']);
        if (isset($attributes['species'])) $character->setSpecies($attributes['species']);
        if (isset($attributes['type'])) $character->setType($attributes['type']);
        if (isset($attributes['gender'])) $character->setGender($attributes['gender']);
        if (isset($attributes['originId']))
            $character->setOrigin($em->getReference(Location::class, $attributes['originId']));
        if (isset($attributes['locationId']))
            $character->setLastLocation($em->getReference(Location::class, $attributes['locationId']));
        if (isset($attributes['image'])) $character->setImage($attributes['image']);
    }
}
