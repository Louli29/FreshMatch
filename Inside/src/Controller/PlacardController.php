<?php
namespace App\Controller;

use App\Entity\Ingredient;
use App\Entity\ListIngrUser;
use App\Entity\User;
use App\Enums\TypeIngredient;
use App\Form\IngredientSelectionType;
use App\Repository\IngredientRepository;
use App\Repository\ListIngrUserRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/placard')]
#[IsGranted('ROLE_USER')]
class PlacardController extends AbstractController
{
    #[Route('/select', name: 'app_placard_select', methods: ['GET', 'POST'])]
    public function selectIngredients(
        Request $request,
        IngredientRepository $ingredientRepository,
        ListIngrUserRepository $listIngrUserRepository,
        EntityManagerInterface $em
    ): \Symfony\Component\HttpFoundation\Response
    {
        $type = $request->query->get('type_ingredient');

        if (!$type || !in_array($type, array_column(TypeIngredient::cases(), 'value'))) {
            throw $this->createNotFoundException('Type d\'ingrédient invalide.');
        }


        $ingredients = $ingredientRepository->findByTypeIngredient($type);

        return $this->render('placard/ingredient_selection_form.html.twig', [
            'ingredients' => $ingredients,
            'type' => $type
        ]);
    }



    #[Route('/add', name: 'app_placard_add', methods: ['POST'])]
    public function addToPlacard(Request $request, EntityManagerInterface $em, IngredientRepository $ingredientRepository): \Symfony\Component\HttpFoundation\RedirectResponse
    {
        $user = $this->getUser(); // Récupération de l'utilisateur connecté
        $ingredientIds = $request->request->all('ingredients');

        if (!$ingredientIds) {
            $this->addFlash('warning', 'Aucun ingrédient sélectionné.');
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
            if ($ingredient) {
                $listIngrUser->addIngredient($ingredient);
            }
        }

        $em->flush();
        $this->addFlash('success', 'Ingrédients ajoutés à votre placard !');

        return $this->redirectToRoute('app_user_account', ['id' => $user->getId()]);
    }


    public function account(User $user, EntityManagerInterface $em): \Symfony\Component\HttpFoundation\Response
    {

        $typeIngredients = TypeIngredient::cases();

        return $this->render('user/my_account.html.twig', [
            'user' => $user,
            'typeIngredients' => $typeIngredients,
        ]);
    }



}
