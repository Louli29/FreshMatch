<?php

namespace App\Controller;

use App\Entity\Ingredient;
use App\Entity\User;
use App\Repository\IngredientRepository;
use App\Repository\RecipeRepository;
use App\Service\RecipeFilter;
use App\Service\Score;
use App\Service\UserPreferences;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ResearchController extends AbstractController

{

    #[Route('/research', name: 'recipe_research', methods: ['GET', 'POST'])]
    public function index(Request $request, RecipeRepository $recipeRepository,  Score $score, UserPreferences $preferences, RecipeFilter $filter): Response
    {
        $ingredientString = $request->query->get('ingredients', '');
        $selectedIngredients = $ingredientString ? explode(',', $ingredientString) : [];
        $selectedIngredients = array_map('trim', $selectedIngredients);

        $user = $this->getUser();
        $pantryIngredients = [];
        $excludedAllergies = [];
        $requiredDiet = null;

        if ($user instanceof \App\Entity\User && $user->getListIngredient()) {
            $pantryIngredients = $preferences->getPantry($user);
            $excludedAllergies = $preferences->getAllergy($user);
            $requiredDiet = $preferences->getDiets($user);
        }

        $recipes = [];
        if (!empty($selectedIngredients) || !empty($pantryIngredients)) {
            $recipes = $recipeRepository->findByIngredients(array_merge($selectedIngredients, $pantryIngredients));
        }

       $filteredRecipes = $filter->filter($recipes, $selectedIngredients, $excludedAllergies, $requiredDiet, $pantryIngredients, $score);

        return $this->render('research/index.html.twig', [
            'recipes' => $filteredRecipes,
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