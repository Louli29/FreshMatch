<?php

namespace App\Controller;

use App\Entity\Ingredient;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ResearchController extends AbstractController

{
    #[Route('/research', name: 'app_research')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $ingredients = $entityManager->getRepository(Ingredient::class)->findBy(array(), array('id' => 'DESC'), 10);



        return $this->render('research/index.html.twig', [
            'controller_name' => 'ResearchController',
            'ingredients' => $ingredients,
        ]);
    }
}
