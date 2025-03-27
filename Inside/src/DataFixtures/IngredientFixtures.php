<?php

namespace App\DataFixtures;

use App\Entity\Ingredient;
use App\Enums\TypeIngredient;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class IngredientFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $ingredients = [
            ['name' => 'Poulet', 'type' => TypeIngredient::VIANDE],
            ['name' => 'Bœuf', 'type' => TypeIngredient::VIANDE],
            ['name' => 'Jambon', 'type' => TypeIngredient::VIANDE],
            ['name' => 'Saucisson', 'type' => TypeIngredient::VIANDE],
            ['name' => 'Saumon', 'type' => TypeIngredient::POISSON],
            ['name' => 'Thon', 'type' => TypeIngredient::POISSON],
            ['name' => 'Maquereau', 'type' => TypeIngredient::POISSON],
            ['name' => 'Crevettes', 'type' => TypeIngredient::POISSON],
            ['name' => 'Sel', 'type' => TypeIngredient::EPICE],
            ['name' => 'Poivre', 'type' => TypeIngredient::EPICE],
            ['name' => 'Paprika', 'type' => TypeIngredient::EPICE],
            ['name' => 'Curry', 'type' => TypeIngredient::EPICE],
            ['name' => 'Cumin', 'type' => TypeIngredient::EPICE],
            ['name' => 'Ail en poudre', 'type' => TypeIngredient::EPICE],
            ['name' => 'Riz', 'type' => TypeIngredient::FECULENT],
            ['name' => 'Pâtes', 'type' => TypeIngredient::FECULENT],
            ['name' => 'Pommes de terre', 'type' => TypeIngredient::FECULENT],
            ['name' => 'Semoule', 'type' => TypeIngredient::FECULENT],
            ['name' => 'Quinoa', 'type' => TypeIngredient::FECULENT],
            ['name' => 'Pomme', 'type' => TypeIngredient::FRUIT],
            ['name' => 'Banane', 'type' => TypeIngredient::FRUIT],
            ['name' => 'Orange', 'type' => TypeIngredient::FRUIT],
            ['name' => 'Fraise', 'type' => TypeIngredient::FRUIT],
            ['name' => 'Raisin', 'type' => TypeIngredient::FRUIT],
            ['name' => 'Lentilles', 'type' => TypeIngredient::LEGUMINEUSE],
            ['name' => 'Pois chiches', 'type' => TypeIngredient::LEGUMINEUSE],
            ['name' => 'Haricots rouges', 'type' => TypeIngredient::LEGUMINEUSE],
            ['name' => 'Flageolets', 'type' => TypeIngredient::LEGUMINEUSE],
            ['name' => 'Carotte', 'type' => TypeIngredient::LEGUME],
            ['name' => 'Tomate', 'type' => TypeIngredient::LEGUME],
            ['name' => 'Courgette', 'type' => TypeIngredient::LEGUME],
            ['name' => 'Poivron', 'type' => TypeIngredient::LEGUME],
            ['name' => 'Concombre', 'type' => TypeIngredient::LEGUME],
            ['name' => 'Oignon', 'type' => TypeIngredient::LEGUME],
            ['name' => 'Beurre', 'type' => TypeIngredient::MATIERE_GRASSE],
            ['name' => 'Huile d\'olive', 'type' => TypeIngredient::MATIERE_GRASSE],
            ['name' => 'Margarine', 'type' => TypeIngredient::MATIERE_GRASSE],
            ['name' => 'Crème fraîche', 'type' => TypeIngredient::MATIERE_GRASSE],
            ['name' => 'Lait', 'type' => TypeIngredient::PRODUIT_LAITIER],
            ['name' => 'Yaourt', 'type' => TypeIngredient::PRODUIT_LAITIER],
            ['name' => 'Fromage', 'type' => TypeIngredient::PRODUIT_LAITIER],
            ['name' => 'Crème', 'type' => TypeIngredient::PRODUIT_LAITIER],
            ['name' => 'Sucre', 'type' => TypeIngredient::PRODUIT_SUCRE],
            ['name' => 'Chocolat', 'type' => TypeIngredient::PRODUIT_SUCRE],
            ['name' => 'Confiture', 'type' => TypeIngredient::PRODUIT_SUCRE],
            ['name' => 'Miel', 'type' => TypeIngredient::PRODUIT_SUCRE],
            ['name' => 'Coca-Cola', 'type' => TypeIngredient::BOISSON],
            ['name' => 'Eau', 'type' => TypeIngredient::BOISSON],
            ['name' => 'Jus de pomme', 'type' => TypeIngredient::BOISSON],
            ['name' => 'Thé', 'type' => TypeIngredient::BOISSON],
            ['name' => 'Café', 'type' => TypeIngredient::BOISSON],
        ];

        foreach ($ingredients as $data) {
            $ingredient = new Ingredient();
            $ingredient->setName($data['name']);
            $ingredient->setTypeIngredient($data['type']);

            $manager->persist($ingredient);
        }


        $manager->flush();
    }
}
