<?php

namespace App\Controller;

use App\Repository\ArtistRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ApiController extends AbstractController
{
    #[Route('/api/artists', name: 'api_artists', methods: ['GET'])]
    public function getArtists(ArtistRepository $artistRepository): JsonResponse
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

    #[Route('/api/artists/{id}', name: 'api_artist', methods: ['GET'])]
    public function getArtist(int $id, ArtistRepository $artistRepository): JsonResponse
    {
        $rows = $artistRepository->getDetails($id);

        $artistData = [
            'id' => $rows[0]['id'],
            'name' => $rows[0]['name'],
            'description' => $rows[0]['description'],
            'image' => $rows[0]['image'] ?? null,
            'events' => []
        ];

        foreach ($rows as $row) {
            if (!empty($row['eventId'])) {
                $artistData['events'][] = [
                    'id' => $row['eventId'],
                    'name' => $row['name'],
                    'date' => $row['date'] instanceof \DateTimeInterface
                        ? $row['date']->format('Y-m-d')
                        : $row['date'],
                ];
            }
        }

        return $this->json($artistData);
    }
}
