<?php

namespace App\Controller\Api;

use App\DTO\In\Location\CreateLocationDto;
use App\DTO\In\Location\GetLocationsDto;
use App\DTO\In\Location\UpdateLocationDto;
use App\Managers\ValidateManager;
use App\Repository\LocationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class LocationController extends AbstractController
{
    public function __construct(
        private readonly LocationRepository $locationRepository,
        private readonly ValidateManager $validateManager,
    ) {}


    /**
     * @param Request $request
     * @return JsonResponse
     */
    #[Route('/location', methods: ['GET'])]
    public function getMany(Request $request): JsonResponse
    {
        $getLocationsDto = GetLocationsDto::fromRequest($request);

        $this->validateManager->validate($getLocationsDto);

        return new JsonResponse($this->locationRepository->findMany($getLocationsDto));
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    #[Route('/location/{id}', methods: ['GET'])]
    public function getById(int $id): JsonResponse
    {
        return new JsonResponse($this->locationRepository->findById($id));
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    #[Route('/location/{id}', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        $this->locationRepository->delete($id);

        return new JsonResponse();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    #[Route('/location', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $createLocationsDto = CreateLocationDto::fromRequest($request);

        $this->validateManager->validate($createLocationsDto);

        return new JsonResponse($this->locationRepository->create($createLocationsDto));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    #[Route('/location/{id}', methods: ['PATCH'])]
    public function update(Request $request): JsonResponse
    {
        $updateLocationDto = UpdateLocationDto::fromRequest($request);

        $this->validateManager->validate($updateLocationDto);

        return new JsonResponse($this->locationRepository->update($updateLocationDto));
    }
}
