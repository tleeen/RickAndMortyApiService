<?php

namespace App\Repository;

use App\DTO\In\Episode\ChangeEpisodeDto;
use App\DTO\In\Episode\CreateEpisodeDto;
use App\DTO\In\Episode\GetEpisodesDto;
use App\DTO\In\Episode\UpdateEpisodeDto;
use App\DTO\Out\Episode\EpisodeDto;
use App\DTO\Paginate\PaginateDto;
use App\Entity\Episode;
use App\Managers\PaginatorManager;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Episode>
 */
class EpisodeRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry                   $registry,
        private readonly PaginatorManager $paginatorManager
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

        if ($getEpisodeDto->ids) {
            $qb->andWhere('episode.id IN (:ids)')
                ->setParameter('ids', $getEpisodeDto->ids);
        }

        return EpisodeDto::fromPaginator($this
            ->paginatorManager
            ->paginate($qb, $getEpisodeDto->page ?: 1));
    }

    /**
     * @param int $id
     * @return EpisodeDto
     */
    public function findById(int $id): EpisodeDto
    {
        return EpisodeDto::fromModel($this->find($id));
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
            'code' => $createEpisodeDto->code]);

        $this->getEntityManager()->persist($episode);
        $this->getEntityManager()->flush();

        return EpisodeDto::fromModel($episode);
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
            'code' => $changeEpisodeDto->code]);

        $this->getEntityManager()->flush();

        return EpisodeDto::fromModel($episode);
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
            'code' => $updateEpisodeDto->code]);

        $this->getEntityManager()->flush();

        return EpisodeDto::fromModel($episode);
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
    }
}
