<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Form\RecipeType;
use App\Repository\RecipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use Symfony\Bundle\SecurityBundle\Security;


#[Route('/recipe')]
final class RecipeController extends AbstractController
{


    #[Route(name: 'app_recipe_index', methods: ['GET'])]
    public function index(RecipeRepository $recipeRepository): Response
    {
        return $this->render('recipe/index.html.twig', [
            'recipes' => $recipeRepository->findAll(),
        ]);
    }

    #[Route('/result', name: 'app_recipe_search', methods: ['GET'])]
    public function search(Request $request, EntityManagerInterface $em): Response
    {
        $ingredientNames = $request->query->all('ingredients');

        if (empty($ingredientNames)) {
            return $this->redirectToRoute('app_recipe_index');
        }

        $qb = $em->createQueryBuilder();

        $qb->select('r')
            ->from('App\Entity\Recipe', 'r')
            ->join('r.ingredientRecipe', 'ir')
            ->join('ir.ingredient', 'i')
            ->where($qb->expr()->in('i.name', ':names'))
            ->setParameter('names', $ingredientNames)
            ->groupBy('r.id');

        $recipes = $qb->getQuery()->getResult();

        return $this->render('recipe/index.html.twig', [
            'recipes' => $recipes,
        ]);
    }


    #[Route('/new', name: 'app_recipe_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager,Security $security): Response
    {
        $user = $security->getUser();
        $recipe = new Recipe();
        $recipe->setUser($user);
        $form = $this->createForm(RecipeType::class, $recipe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($recipe);
            $entityManager->flush();

            return $this->redirectToRoute('app_user_account', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('recipe/new.html.twig', [
            'recipe' => $recipe,
            'form' => $form,
        ]);
    }

    #[Route('/my_recipe', name: 'app_my_recipe_index', methods: ['GET'])]
    public function myRecipe(Security $security, RecipeRepository $repo): Response
    {
        $user = $security->getUser();
        $recipes = $repo->findBy(['user' => $user]);

        return $this->render('recipe/index.html.twig', [
            'recipes' => $recipes,
        ]);
    }

    #[Route('/{id}', name: 'app_recipe_show', methods: ['GET'])]
    public function show(Recipe $recipe): Response
    {
        return $this->render('recipe/show.html.twig', [
            'recipe' => $recipe,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_recipe_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Recipe $recipe, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RecipeType::class, $recipe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_recipe_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('recipe/edit.html.twig', [
            'recipe' => $recipe,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_recipe_delete', methods: ['POST'])]
    public function delete(Request $request, Recipe $recipe, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$recipe->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($recipe);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_recipe_index', [], Response::HTTP_SEE_OTHER);
    }
}
