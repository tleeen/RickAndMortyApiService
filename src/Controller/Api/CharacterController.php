<?php

namespace App\Controller\Api;

use App\Contracts\Managers\Validation\ValidateManagerInterface;
use App\Contracts\Repositories\Character\CharacterRepositoryInterface;
use App\Exceptions\Validation\ValidateException;
use App\Utils\Mappers\In\Character\ChangeCharacterDtoMapper;
use App\Utils\Mappers\In\Character\CreateCharacterDtoMapper;
use App\Utils\Mappers\In\Character\GetCharactersDtoMapper;
use App\Utils\Mappers\In\Character\UpdateCharacterDtoMapper;
use Doctrine\ORM\Exception\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/character', name: 'character_')]
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
    #[Route('/', name: 'get', methods: ['GET'])]
    public function getMany(Request $request): JsonResponse
    {
        $getCharactersDto = GetCharactersDtoMapper::fromRequest($request);

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
    #[Route('/{id}', name: 'index', methods: ['GET'])]
    public function getById(int $id): JsonResponse
    {
        return new JsonResponse($this->characterRepository->findById($id));
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    #[Route('/{id}', methods: ['DELETE'])]
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
    #[Route('/', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $createCharacterDto = CreateCharacterDtoMapper::fromRequest($request);

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
    #[Route('/{id}', methods: ['PATCH'])]
    public function change(Request $request): JsonResponse
    {
        $changeCharacterDto = ChangeCharacterDtoMapper::fromRequest($request);

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
    #[Route('/{id}', methods: ['PUT'])]
    public function update(Request $request): JsonResponse
    {
        $updateCharacterDto = UpdateCharacterDtoMapper::fromRequest($request);

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
