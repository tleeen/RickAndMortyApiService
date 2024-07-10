<?php

namespace App\Repository\Episode;

use App\Contracts\Managers\Pagination\PaginateManagerInterface;
use App\Contracts\Managers\UrlGeneration\UrlGenerateManagerInterface;
use App\Contracts\Repositories\Character\CharacterRepositoryInterface;
use App\Contracts\Repositories\Episode\EpisodeRepositoryInterface;
use App\DTO\In\Episode\ChangeEpisodeDto;
use App\DTO\In\Episode\CreateEpisodeDto;
use App\DTO\In\Episode\GetEpisodesDto;
use App\DTO\In\Episode\UpdateEpisodeDto;
use App\DTO\Out\Episode\EpisodeDto;
use App\DTO\Paginate\PaginateDto;
use App\Entity\Episode;
use App\Filter\Filters\Episode\EpisodeFilterFactory;
use App\Filter\HasFilter;
use App\Utils\Mappers\Out\Episode\EpisodeDtoMapper;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Episode>
 */
class EpisodeRepository extends ServiceEntityRepository implements EpisodeRepositoryInterface
{
    use HasFilter;

    public function __construct(
        ManagerRegistry                   $registry,
        private readonly PaginateManagerInterface $paginatorManager,
        private readonly CharacterRepositoryInterface $characterRepository,
        private readonly UrlGenerateManagerInterface $urlGenerator,
    )
    {
        parent::__construct($registry, Episode::class);
    }

    /**
     * @param GetEpisodesDto $getEpisodeDto
     * @return PaginateDto
     */
    public function findMany(GetEpisodesDto $getEpisodeDto): PaginateDto
    {
        $qb = $this->createQueryBuilder('episode');

        $qb = $this->filterBy($qb, EpisodeFilterFactory::create($getEpisodeDto->filters));

        if ($getEpisodeDto->ids) {
            $qb->andWhere('episode.id IN (:ids)')
                ->setParameter('ids', $getEpisodeDto->ids);
        }

        return EpisodeDtoMapper::fromPaginator($this
            ->paginatorManager
            ->paginate($qb, $getEpisodeDto->page ?: 1, $getEpisodeDto->limit ?: 10),
            $this->urlGenerator);
    }

    /**
     * @param int $id
     * @return EpisodeDto
     */
    public function findById(int $id): EpisodeDto
    {
        return EpisodeDtoMapper::fromModel($this->find($id), $this->urlGenerator);
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
     * @param CreateEpisodeDto $createEpisodeDto
     * @return EpisodeDto
     */
    public function create(CreateEpisodeDto $createEpisodeDto): EpisodeDto
    {
        $episode = new Episode();

        $this->setAttributes($episode, [
            'name' => $createEpisodeDto->name,
            'airDate' => $createEpisodeDto->airDate,
            'code' => $createEpisodeDto->code,
            'characterIds' => $createEpisodeDto->characterIds]);

        $this->getEntityManager()->persist($episode);
        $this->getEntityManager()->flush();

        return EpisodeDtoMapper::fromModel($episode, $this->urlGenerator);
    }

    /**
     * @param ChangeEpisodeDto $changeEpisodeDto
     * @return EpisodeDto
     */
    public function change(ChangeEpisodeDto $changeEpisodeDto): EpisodeDto
    {
        /** @var Episode $episode */
        $episode = $this->find($changeEpisodeDto->id);

        $this->setAttributes($episode, [
            'name' => $changeEpisodeDto->name,
            'airDate' => $changeEpisodeDto->airDate,
            'code' => $changeEpisodeDto->code,
            'characterIds' => $changeEpisodeDto->characterIds]);

        $this->getEntityManager()->flush();

        return EpisodeDtoMapper::fromModel($episode, $this->urlGenerator);
    }

    /**
     * @param UpdateEpisodeDto $updateEpisodeDto
     * @return EpisodeDto
     */
    public function updateOrCreate(UpdateEpisodeDto $updateEpisodeDto): EpisodeDto
    {
        /** @var Episode $episode */
        $episode = $this->find($updateEpisodeDto->id);

        if (!$episode) $episode = new Episode();

        $this->setAttributes($episode, [
            'name' => $updateEpisodeDto->name,
            'airDate' => $updateEpisodeDto->airDate,
            'code' => $updateEpisodeDto->code,
            'characterIds' => $updateEpisodeDto->characterIds]);

        $this->getEntityManager()->flush();

        return EpisodeDtoMapper::fromModel($episode, $this->urlGenerator);
    }

    /**
     * @param Episode $episode
     * @param array $attributes
     * @return void
     */
    private function setAttributes(Episode $episode, array $attributes): void
    {
        if (isset($attributes['name'])) $episode->setName($attributes['name']);
        if (isset($attributes['airDate']))
            $episode->setAirDate(DateTime::createFromFormat('Y-m-d', $attributes['airDate']));
        if (isset($attributes['code'])) $episode->setCode($attributes['code']);
        if (isset($attributes['characterIds'])) {
            $existingCharacterIds = $episode->getCharacters()->map(function ($character) {
                return $character->getId();
            })->toArray();

            $characterIdsToAdd = array_diff($attributes['characterIds'], $existingCharacterIds);
            $characterIdsToRemove = array_diff($existingCharacterIds, $attributes['characterIds']);

            foreach ($characterIdsToAdd as $characterId) {
                $character = $this->characterRepository->find($characterId);
                $episode->addCharacter($character);
            }

            foreach ($characterIdsToRemove as $characterId) {
                $character = $this->characterRepository->find($characterId);
                $episode->removeCharacter($character);
            }
        }
    }
}
