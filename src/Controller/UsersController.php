<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class UsersController extends AbstractController
{
    #[Route('/users', name: 'app_users')]
    public function index(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();

        return $this->render('users/index.html.twig', [
            'controller_name' => 'UsersController',
            'users' => $users,
        ]);
    }
}
