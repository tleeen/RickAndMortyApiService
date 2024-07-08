<?php

namespace App\Controller\Api;

use App\Contracts\Managers\Validation\IValidateManager;
use App\Contracts\Repositories\Location\ILocationRepository;
use App\DTO\In\Location\ChangeLocationDto;
use App\DTO\In\Location\CreateLocationDto;
use App\DTO\In\Location\GetLocationsDto;
use App\DTO\In\Location\UpdateLocationDto;
use App\Exceptions\Validation\ValidateException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class LocationController extends AbstractController
{
    public function __construct(
        private readonly ILocationRepository $locationRepository,
        private readonly IValidateManager    $validateManager,
    ) {}

    /**
     * @param Request $request
     * @return JsonResponse
     */
    #[Route('/location', methods: ['GET'])]
    public function getMany(Request $request): JsonResponse
    {
        $getLocationsDto = GetLocationsDto::fromRequest($request);

        try {
            $this->validateManager->validate($getLocationsDto);
            return new JsonResponse($this->locationRepository->findMany($getLocationsDto));
        } catch (ValidateException $e) {
            return new JsonResponse([
                'message' => $e->getMessage(),
            ], $e->getStatusCode());
        }
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
        $createLocationDto = CreateLocationDto::fromRequest($request);

        try {
            $this->validateManager->validate($createLocationDto);
            return new JsonResponse($this->locationRepository->create($createLocationDto));
        } catch (ValidateException $e) {
            return new JsonResponse([
                'message' => $e->getMessage(),
            ], $e->getStatusCode());
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    #[Route('/location/{id}', methods: ['PATCH'])]
    public function change(Request $request): JsonResponse
    {
        $changeLocationDto = ChangeLocationDto::fromRequest($request);

        try {
            $this->validateManager->validate($changeLocationDto);
            return new JsonResponse($this->locationRepository->change($changeLocationDto));
        } catch (ValidateException $e) {
            return new JsonResponse([
                'message' => $e->getMessage(),
            ], $e->getStatusCode());
        }
    }

    #[Route('/location/{id}', methods: ['PUT'])]
    public function update(Request $request): JsonResponse
    {
        $updateLocationDto = UpdateLocationDto::fromRequest($request);

        try {
            $this->validateManager->validate($updateLocationDto);
        } catch (ValidateException $e) {
            return new JsonResponse([
                'message' => $e->getMessage(),
            ], $e->getStatusCode());
        }

        return new JsonResponse($this->locationRepository->updateOrCreate($updateLocationDto));
    }
}
