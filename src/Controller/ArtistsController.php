<?php

namespace App\Controller;

use App\Repository\ArtistRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ArtistsController extends AbstractController
{
    #[Route('/artists/{id}', name: 'app_artist_details')]
    public function details(int $id, ArtistRepository $artistRepository): Response
    {
        $artist = $artistRepository->getDetails($id);

        return $this->render('artists/details.html.twig', [
            'artist' => $artist,
        ]);
    }
    #[Route('/artists', name: 'app_artists')]
    public function index(ArtistRepository $artistRepository): Response
    {
        $artists = $artistRepository->selectNameImage();

        return $this->render('artists/index.html.twig', [
            'controller_name' => 'ArtistsController',
            'artists' => $artists,
        ]);
    }
}
