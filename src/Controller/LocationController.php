<?php

namespace App\Controller;

use App\Repository\CharacterRepository;
use App\Repository\LocationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class LocationController extends AbstractController
{
    public function __construct(
        private readonly LocationRepository $locationRepository,
        private readonly CharacterRepository $characterRepository,
    ) {}
    #[Route('/location', name: 'app_location')]
    public function index(): JsonResponse
    {
        dd($this->characterRepository->findById(2)->getEpisodes()->first()->getName());
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/LocationController.php',
        ]);
    }
}
