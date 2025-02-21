<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class UserController extends AbstractController
{
    #[Route('/User', name: 'app_User')]
    public function index(): Response
    {
        return $this->render('User/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
}
