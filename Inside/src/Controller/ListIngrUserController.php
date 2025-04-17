<?php
namespace App\Controller;

use App\Entity\ListIngrUser;
use App\Entity\User;
use App\Enums\TypeIngredient;
use App\Repository\IngredientRepository;
use App\Service\ListIngrUserService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/placard')]
#[IsGranted('ROLE_USER')]
class ListIngrUserController extends AbstractController
{
    #[Route('/select', name: 'app_listIngrUser_select', methods: ['GET', 'POST'])]
    public function selectIngredients(Request $request,IngredientRepository $ingredientRepository, \App\Service\ListIngrUserService $listIngrUserService): \Symfony\Component\HttpFoundation\Response
    {
        $type = $request->query->get('type_ingredient');
        $erreurType = null;
        if (!$type) {
            $erreurType = 'Veuillez sélectionner un type d\'ingrédient.';
        }

        $alreadyInPlacard= [];
        $user = $this->getUser();
        $listIngrUser = $user->getListIngredient();

        if ($user instanceof \App\Entity\User && $user->getListIngredient()) {
            $alreadyInPlacard = $listIngrUser ? $listIngrUserService->getListIngredientsId($user) : [];
        }

        $ingredients = [];

        if (!$erreurType) {
            $ingredients = $ingredientRepository->findByTypeIngredient($type);
            if (!empty($alreadyInPlacard)) {
                $ingredients = $listIngrUserService->ingredientsFilter($ingredients, $alreadyInPlacard);
            }
        }

        return $this->render('list_ingr_user/ingredient_selection_form.html.twig', [
            'ingredients' => $ingredients,
            'type' => $type,
            'erreurType' => $erreurType,
            'typeIngredients' => TypeIngredient::cases(),
            'listIngrUser' => $listIngrUser,
            'user' => $user
        ]);
    }

    #[Route('/add', name: 'app_listIngrUser_add', methods: ['POST'])]
    public function addToPlacard(Request $request, EntityManagerInterface $em, IngredientRepository $ingredientRepository, ListIngrUserService $listIngrUserService): \Symfony\Component\HttpFoundation\RedirectResponse
    {
        $ingredientIds = $request->request->all('ingredients');
        $user = $this->getUser();

        if (!$ingredientIds) {
            return $this->redirectToRoute('app_user_account', ['id' => $user->getId()]);
        }

        $listIngrUser = $user->getListIngredient();

        if (!$listIngrUser) {
            $listIngrUser = new ListIngrUser();
            $listIngrUser->setUser($user);
            $em->persist($listIngrUser);
        }

        foreach ($ingredientIds as $ingredientId) {
            $ingredient = $ingredientRepository->find($ingredientId);
            $listIngrUser->addIngredient($ingredient);
        }
        $em->flush();

        return $this->redirectToRoute('app_user_account', ['id' => $user->getId()]);
    }

    #[Route('/remove', name: 'app_listIngrUser_remove', methods: ['POST'])]
    public function removeFromPlacard(Request $request, EntityManagerInterface $em, IngredientRepository $ingredientRepository):\Symfony\Component\HttpFoundation\RedirectResponse
    {
        $user = $this->getUser();
        $ingredientId = $request->request->get('ingredient_id');
        $ingredient = $ingredientRepository->find($ingredientId);

        $listIngrUser = $user->getListIngredient();
        if ($listIngrUser && $listIngrUser->getIngredient()->contains($ingredient)) {
            $listIngrUser->removeIngredient($ingredient);
            $em->flush();
            return $this->redirectToRoute('app_user_account', ['id' => $user->getId()]);
        }

        return $this->redirectToRoute('app_user_account', ['id' => $user->getId()]);
    }
}
