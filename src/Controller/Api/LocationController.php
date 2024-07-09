<?php

namespace App\Controller\Api;

use App\Contracts\Managers\Validation\ValidateManagerInterface;
use App\Contracts\Repositories\Location\LocationRepositoryInterface;
use App\Exceptions\Validation\ValidateException;
use App\Utils\Mappers\In\Location\ChangeLocationDtoMapper;
use App\Utils\Mappers\In\Location\CreateLocationDtoMapper;
use App\Utils\Mappers\In\Location\GetLocationsDtoMapper;
use App\Utils\Mappers\In\Location\UpdateLocationDtoMapper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/location', name: 'location_')]
class LocationController extends AbstractController
{
    public function __construct(
        private readonly LocationRepositoryInterface $locationRepository,
        private readonly ValidateManagerInterface    $validateManager,
    ) {}

    /**
     * @param Request $request
     * @return JsonResponse
     */
    #[Route('/', name: "get", methods: ['GET'])]
    public function getMany(Request $request): JsonResponse
    {
        $getLocationsDto = GetLocationsDtoMapper::fromRequest($request);

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
    #[Route('/{id}', name: "index", methods: ['GET'])]
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
    #[Route('/', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $createLocationDto = CreateLocationDtoMapper::fromRequest($request);

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
    #[Route('/{id}', methods: ['PATCH'])]
    public function change(Request $request): JsonResponse
    {
        $changeLocationDto = ChangeLocationDtoMapper::fromRequest($request);

        try {
            $this->validateManager->validate($changeLocationDto);
            return new JsonResponse($this->locationRepository->change($changeLocationDto));
        } catch (ValidateException $e) {
            return new JsonResponse([
                'message' => $e->getMessage(),
            ], $e->getStatusCode());
        }
    }

    #[Route('/{id}', methods: ['PUT'])]
    public function update(Request $request): JsonResponse
    {
        $updateLocationDto = UpdateLocationDtoMapper::fromRequest($request);

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
