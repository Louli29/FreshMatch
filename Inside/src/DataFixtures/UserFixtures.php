<?php

namespace App\DataFixtures;

use AllowDynamicProperties;
use App\Entity\Ingredient;
use App\Enums\Allergy;
use App\Enums\Diet;
use App\Entity\User;
use App\Entity\ListIngrUser;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AllowDynamicProperties] class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // Récupération des ingrédients existants
        $ingredients = $manager->getRepository(Ingredient::class)->findAll();
        if (empty($ingredients)) {
            throw new \Exception("Aucun ingrédient trouvé en base. Ajoutez d'abord des ingrédients !");
        }

        $usersData = [
            [
                'email' => 'alice@example.com',
                'name' => 'Alice Dupont',
                'diet' => Diet::VEGETARIEN,
                'allergies' => [Allergy::FRUIT_A_COQUE, Allergy::FRUIT_DE_MER],
            ],
            [
                'email' => 'bob@example.com',
                'name' => 'Bob Martin',
                'diet' => Diet::VEGAN,
                'allergies' => [Allergy::GLUTEN],
            ],
            [
                'email' => 'charlie@example.com',
                'name' => 'Charlie Durand',
                'diet' => null,
                'allergies' => null,
            ],
            [
                'email' => 'diane@example.com',
                'name' => 'Diane Petit',
                'diet' => null,
                'allergies' => [Allergy::GLUTEN, Allergy::LACTOSE],
            ],
            [
                'email' => 'eric@example.com',
                'name' => 'Eric Morel',
                'diet' => Diet::VEGAN,
                'allergies' => [Allergy::FRUIT_A_COQUE],
            ],
        ];


        foreach ($usersData as $userData) {

            $user = new User();
            $user->setEmail($userData['email'])
                ->setName($userData['name'])
                ->setRoles(['ROLE_USER'])
                ->setDiet($userData['diet'] ?? null)
                ->setAllergy(!empty($userData['allergies']) ? $userData['allergies'] : null);


            $hashedPassword = $this->passwordHasher->hashPassword($user, 'password123');
            $user->setPassword($hashedPassword);


            $listIngrUser = new ListIngrUser();


            shuffle($ingredients);
            foreach (array_slice($ingredients, 0, 3) as $ingredient) {
                $listIngrUser->addIngredient($ingredient);
            }

            $listIngrUser->setUser($user);
            $user->setListIngredient($listIngrUser);


            $manager->persist($listIngrUser);
            $manager->persist($user);
        }

        $manager->flush();
    }
}
