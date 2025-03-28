<?php

namespace App\Controller;

use App\Entity\Artist;
use App\Form\ArtistType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;
use Imagine\Gd\Imagine;
use Imagine\Image\Box;
use Imagine\Image\Point;

final class NewArtistController extends AbstractController
{
    /**
     * @throws \Exception
     */
    #[Route('/newArtist', name: 'app_new_artist')]
    public function index(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $artist = new Artist();
        $form = $this->createForm(ArtistType::class, $artist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $imageFile */
            $imageFile = $form->get('image')->getData();

            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . '.jpg';

                $uploadDir = $this->getParameter('images_directory');
                $tempPath = $imageFile->getPathname();

                try {
                    // Open and crop the image using Imagine
                    $imagine = new Imagine();
                    $image = $imagine->open($tempPath);

                    $size = $image->getSize();
                    $width = $size->getWidth();
                    $height = $size->getHeight();

                    $cropSize = min($width, $height);
                    $x = floor(($width - $cropSize) / 2);
                    $y = floor(($height - $cropSize) / 2);

                    $image
                        ->crop(new Point($x, $y), new Box($cropSize, $cropSize))
                        ->save($uploadDir . '/' . $newFilename, [
                            'format' => 'jpg',
                            'jpeg_quality' => 80,
                        ]);
                } catch (\Exception $e) {
                    throw new \Exception("Error while processing the image: " . $e->getMessage());
                }

                $artist->setImage($newFilename);
            }

            $entityManager->persist($artist);
            $entityManager->flush();

            $this->addFlash('success', 'Artist created!');

            return $this->redirectToRoute('app_home_page');
        }

        return $this->render('new_artist/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
