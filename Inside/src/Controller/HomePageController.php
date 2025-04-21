<?php

namespace App\Controller;

use App\Service\SeasonService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomePageController extends AbstractController
{

    public function __construct(private SeasonService $seasonService)
    {

    }

    #[Route('/', name: 'home_page', methods:['GET'])]
    public function index(): Response
    {
        $content = $this->seasonService->getRecipeSeason();
        return $this->render('home_page/HomePage.html.twig', ['saison' => $content['saison'], 'recipes' => $content['recipes'],]);
    }
}
