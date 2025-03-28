<?php

namespace App\Controller;

use App\Repository\ArtistRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ApiController extends AbstractController
{
    #[Route('/api/artists', name: 'api_artists', methods: ['GET'])]
    public function getArtists(ArtistRepository $artistRepository): \Symfony\Component\HttpFoundation\JsonResponse
    {
        $artists = $artistRepository->selectNameDescriptionImage();

        $data = [];

        foreach ($artists as $artist) {
            $data[] = [
                'id' => $artist['id'],
                'name' => $artist['name'],
                'description' => $artist['description'],
            ];
        }

        return $this->json($data);
    }
}
