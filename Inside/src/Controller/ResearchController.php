<?php

namespace App\Controller;

use App\Entity\Ingredient;
use App\Repository\IngredientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ResearchController extends AbstractController

{

    #[Route('/research', name: 'recipe_research', methods:['GET','POST'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $ingredients = $entityManager->getRepository(Ingredient::class)->findBy(array(), array('id' => 'DESC'), 10);
        return $this->render('research/index.html.twig', [
            'ingredients' => $ingredients,
        ]);
    }

    #[Route('/autocomplete/ingredients', name: 'autocomplete_ingredients')]
    public function autocomplete(Request $request, IngredientRepository $ingredientRepository): JsonResponse
    {
        $term = $request->query->get('term');

        $results = $ingredientRepository->createQueryBuilder('i')
            ->where('i.name LIKE :term')
            ->setParameter('term', '%' . $term . '%')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();

        $ingredients = array_map(fn($ingredient) => ['name' => $ingredient->getName()], $results);

        return new JsonResponse($ingredients);
    }
}
