<?php

namespace App\Controller;

use App\Enums\Season;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomePageController extends AbstractController
{
    #[Route('/', name: 'home_page', methods:['GET'])]
    public function index(): Response
    {
        $year = (int) date('Y'); // Permet de récupérer l'année actuelle
        $saisons=[]; // Créer un tableau qui stocke toutes les saisons avec leur date de début et de fin associé
        foreach(Season::cases() as $saison){ // Parcours toute l'énumération Saison
            $saisons[$saison->value] = $saison->getDates($year); // Récupère les dates associées aux saisons
        }

        return $this->render('home_page/HomePage.html.twig', [
            'saisons'=>$saisons, 'dateActuelle'=> (new \DateTime())->format('Y-m-d'),
        ]);
    }
}
