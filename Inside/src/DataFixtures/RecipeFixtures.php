<?php

namespace App\DataFixtures;

use App\Entity\Recipe;
use App\Entity\Ingredient;
use App\Entity\IngredientRecipe;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RecipeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $recipes = [
            [
                'name' => 'Poulet au curry',
                'time' => 45,
                'description' => 'Un plat savoureux de poulet épicé au curry.',
                'step' => '1. Faire revenir le poulet. 2. Ajouter le curry et la crème. 3. Laisser mijoter.',
                'nbPerson' => 4,
                'imageLink' => 'poulet-au-curry.webp',
                'ingredients' => [
                    ['name' => 'Poulet', 'quantity' => 500, 'unite' => 'g', 'remplacable' => false],
                    ['name' => 'Curry', 'quantity' => 10, 'unite' => 'g', 'remplacable' => true],
                    ['name' => 'Crème fraîche', 'quantity' => 200, 'unite' => 'ml', 'remplacable' => false],
                ]
            ],
            [
                'name' => 'Salade de quinoa',
                'time' => 20,
                'description' => 'Une salade fraîche et équilibrée avec du quinoa.',
                'step' => '1. Cuire le quinoa. 2. Ajouter les légumes coupés. 3. Assaisonner.',
                'nbPerson' => 2,
                'imageLink' => 'salade-de-quinoa.jpg',
                'ingredients' => [
                    ['name' => 'Salade', 'quantity' => 250, 'unite'=>'g','remplacable'=>false],
                    ['name' => 'Tomate', 'quantity' => 2, 'unite' => 'pièce', 'remplacable' => true],
                    ['name' => 'Huile d’olive', 'quantity' => 10, 'unite' => 'ml', 'remplacable' => true],
                ]
            ]
        ];

        foreach ($recipes as $data) {
            // Create the recipe
            $recipe = new Recipe();
            $recipe->setName($data['name']);
            $recipe->setTime($data['time']);
            $recipe->setDescription($data['description']);
            $recipe->setStep($data['step']);
            $recipe->setNbPerson($data['nbPerson']);
            $recipe->setImageLink($data['imageLink']);

            $user = $manager->getRepository(User::class)->findOneBy(['id'=>1]);

            $recipe->setUser($user);
            // Persist the recipe
            $manager->persist($recipe);

            // Add ingredients and link to the recipe
            foreach ($data['ingredients'] as $ingredientData) {
                // Find the ingredient by name
                $ingredient = $manager->getRepository(Ingredient::class)->findOneBy(['name' => $ingredientData['name']]);

                if ($ingredient) {
                    // Create a new IngredientRecipe object
                    $ingredientRecipe = new IngredientRecipe();
                    $ingredientRecipe->setRecipe($recipe);  // Associate the recipe
                    $ingredientRecipe->setIngredient($ingredient);  // Associate the ingredient
                    $ingredientRecipe->setQuantity($ingredientData['quantity']);
                    $ingredientRecipe->setUnite($ingredientData['unite']);
                    $ingredientRecipe->setRemplacable($ingredientData['remplacable']);

                    // Add the IngredientRecipe to the recipe
                    $recipe->addIngredientRecipe($ingredientRecipe);

                    // Persist the IngredientRecipe entity
                    $manager->persist($ingredientRecipe);
                }
            }
        }

        // Flush the changes to the database
        $manager->flush();
    }
}
?>

