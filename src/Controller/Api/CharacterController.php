<?php

namespace App\Controller\Api;

use App\Contracts\Managers\Validation\ValidateManagerInterface;
use App\Contracts\Repositories\Character\CharacterRepositoryInterface;
use App\DTO\In\Character\ChangeCharacterDto;
use App\DTO\In\Character\CreateCharacterDto;
use App\DTO\In\Character\GetCharactersDto;
use App\DTO\In\Character\UpdateCharacterDto;
use App\Exceptions\Validation\ValidateException;
use Doctrine\ORM\Exception\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class CharacterController extends AbstractController
{
    public function __construct(
        private readonly CharacterRepositoryInterface $characterRepository,
        private readonly ValidateManagerInterface     $validateManager,
    ) {}

    /**
     * @param Request $request
     * @return JsonResponse
     */
    #[Route('/character', methods: ['GET'])]
    public function getMany(Request $request): JsonResponse
    {
        $getCharactersDto = GetCharactersDto::fromRequest($request);

        try {
            $this->validateManager->validate($getCharactersDto);
            return new JsonResponse($this->characterRepository->findMany($getCharactersDto));
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
    #[Route('/character/{id}', methods: ['GET'])]
    public function getById(int $id): JsonResponse
    {
        return new JsonResponse($this->characterRepository->findById($id));
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    #[Route('/character/{id}', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        $this->characterRepository->delete($id);

        return new JsonResponse();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ORMException
     */
    #[Route('/character', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $createCharacterDto = CreateCharacterDto::fromRequest($request);

        try {
            $this->validateManager->validate($createCharacterDto);
            return new JsonResponse($this->characterRepository->create($createCharacterDto));
        } catch (ValidateException $e) {
            return new JsonResponse([
                'message' => $e->getMessage(),
            ], $e->getStatusCode());
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ORMException
     */
    #[Route('/character/{id}', methods: ['PATCH'])]
    public function change(Request $request): JsonResponse
    {
        $changeCharacterDto = ChangeCharacterDto::fromRequest($request);

        try {
            $this->validateManager->validate($changeCharacterDto);
            return new JsonResponse($this->characterRepository->change($changeCharacterDto));
        } catch (ValidateException $e) {
            return new JsonResponse([
                'message' => $e->getMessage(),
            ], $e->getStatusCode());
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ORMException
     */
    #[Route('/character/{id}', methods: ['PUT'])]
    public function update(Request $request): JsonResponse
    {
        $updateCharacterDto = UpdateCharacterDto::fromRequest($request);

        try {
            $this->validateManager->validate($updateCharacterDto);
            return new JsonResponse($this->characterRepository->updateOrCreate($updateCharacterDto));
        } catch (ValidateException $e) {
            return new JsonResponse([
                'message' => $e->getMessage(),
            ], $e->getStatusCode());
        }
    }
}
