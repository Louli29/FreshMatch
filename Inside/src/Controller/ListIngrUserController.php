<?php

namespace App\Controller;

use App\Entity\Ingredient;
use App\Entity\ListIngrUser;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ListIngrUserController extends AbstractController
{


    #[Route('/autocomplete/ingredients', name: 'autocomplete_ingredients', methods: ['GET'])]
    public function autocompleteIngredients(Request $request, EntityManagerInterface $em): \Symfony\Component\HttpFoundation\JsonResponse
    {
        $term = $request->query->get('term', '');


        $ingredients = $em->getRepository(Ingredient::class)->createQueryBuilder('i')
            ->where('i.name LIKE :term')
            ->setParameter('term', $term . '%')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();


        $results = [];
        foreach ($ingredients as $ingredient) {
            $results[] = [
                'id' => $ingredient->getId(),
                'name' => $ingredient->getName(),
            ];
        }

        return $this->json($results);
    }

    #[Route('/add-ingredient', name: 'add_ingredient', methods: ['POST'])]
    public function addIngredient(Request $request, EntityManagerInterface $em): \Symfony\Component\HttpFoundation\JsonResponse
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->json(['error' => 'Utilisateur non connecté'], Response::HTTP_UNAUTHORIZED);
        }

        $data = json_decode($request->getContent(), true);
        $ingredientId = $data['ingredient_id'] ?? null;

        if (!$ingredientId) {
            return $this->json(['error' => 'ID ingrédient manquant'], Response::HTTP_BAD_REQUEST);
        }


        $ingredient = $em->getRepository(Ingredient::class)->find($ingredientId);
        if (!$ingredient) {
            return $this->json(['error' => 'Ingrédient introuvable'], Response::HTTP_NOT_FOUND);
        }

        $listIngrUser = $user->getListIngredient();
        if (!$listIngrUser) {
            $listIngrUser = new ListIngrUser();
            $listIngrUser->setUser($user);
            $em->persist($listIngrUser);
        }


        if (!$listIngrUser->getIngredient()->contains($ingredient)) {
            $listIngrUser->addIngredient($ingredient);
            $em->persist($listIngrUser);
            $em->flush();
        }

        return $this->json([
            'success' => 'Ingrédient ajouté au placard',
            'ingredient' => [
                'id' => $ingredient->getId(),
                'name' => $ingredient->getName(),
                'type' => $ingredient->getTypeIngredient()->value,
            ]
        ]);
    }



}
