<?php

namespace App\Controller;

use App\Entity\Ingredient;
use App\Repository\IngredientRepository;
use App\Repository\RecipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ResearchController extends AbstractController

{

    #[Route('/research', name: 'recipe_research', methods: ['GET', 'POST'])]
    public function index(Request $request, RecipeRepository $recipeRepository): Response
    {

        $ingredientString = $request->query->get('ingredients','');

        $selectedIngredients= $ingredientString ? explode(',', $ingredientString) : [];
       /* if (!is_array($selectedIngredients)) {
            $selectedIngredients = [$selectedIngredients];
        }*/


        $selectedIngredients = array_map('trim', $selectedIngredients);


        $recipes = [];
        if (!empty($selectedIngredients)) {
            $recipes = $recipeRepository->findByIngredients($selectedIngredients);
        }


        return $this->render('research/index.html.twig', [
            'recipes' => $recipes,
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
