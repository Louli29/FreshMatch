<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ResearchController extends AbstractController
{
    #[Route('/Research', name: 'app_Research')]
    public function index(): Response
    {
        return $this->render('Research/index.html.twig', [
            'controller_name' => 'ResearchController',
        ]);
    }
}
