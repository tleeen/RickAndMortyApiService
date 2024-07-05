<?php

namespace App\Controller\Api;

use App\DTO\In\Episode\CreateEpisodeDto;
use App\DTO\In\Episode\GetEpisodesDto;
use App\DTO\In\Episode\UpdateEpisodeDto;
use App\Exceptions\Validation\ValidateException;
use App\Managers\ValidateManager;
use App\Repository\EpisodeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class EpisodeController extends AbstractController
{
    public function __construct(
        private readonly EpisodeRepository $episodeRepository,
        private readonly ValidateManager    $validateManager,
    ) {}
    /**
     * @param Request $request
     * @return JsonResponse
     */
    #[Route('/episode', methods: ['GET'])]
    public function getMany(Request $request): JsonResponse
    {
        $getEpisodesDto = GetEpisodesDto::fromRequest($request);

        try {
            $this->validateManager->validate($getEpisodesDto);
        } catch (ValidateException $e) {
            return new JsonResponse([
                'message' => $e->getMessage(),
            ], $e->getStatusCode());
        }

        return new JsonResponse($this->episodeRepository->findMany($getEpisodesDto));
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    #[Route('/episode/{id}', methods: ['GET'])]
    public function getById(int $id): JsonResponse
    {
        return new JsonResponse($this->episodeRepository->findById($id));
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    #[Route('/episode/{id}', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        $this->episodeRepository->delete($id);

        return new JsonResponse();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    #[Route('/episode', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $createEpisodeDto = CreateEpisodeDto::fromRequest($request);

        try {
            $this->validateManager->validate($createEpisodeDto);
        } catch (ValidateException $e) {
            return new JsonResponse([
                'message' => $e->getMessage(),
            ], $e->getStatusCode());
        }

        return new JsonResponse($this->episodeRepository->create($createEpisodeDto));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    #[Route('/episode/{id}', methods: ['PATCH'])]
    public function update(Request $request): JsonResponse
    {
        $updateEpisodeDto = UpdateEpisodeDto::fromRequest($request);

        try {
            $this->validateManager->validate($updateEpisodeDto);
        } catch (ValidateException $e) {
            return new JsonResponse([
                'message' => $e->getMessage(),
            ], $e->getStatusCode());
        }

        return new JsonResponse($this->episodeRepository->change($updateEpisodeDto));
    }
}
