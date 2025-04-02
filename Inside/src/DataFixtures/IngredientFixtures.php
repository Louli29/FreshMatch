<?php

namespace App\DataFixtures;

use App\Entity\Ingredient;
use App\Enums\Season;
use App\Enums\TypeIngredient;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class IngredientFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $ingredients = [
            ['Poulet', TypeIngredient::VIANDE],
            ['Bœuf', TypeIngredient::VIANDE],
            ['Porc', TypeIngredient::VIANDE],
            ['Agneau', TypeIngredient::VIANDE],
            ['Dinde', TypeIngredient::VIANDE],
            ['Saumon', TypeIngredient::POISSON],
            ['Thon', TypeIngredient::POISSON],
            ['Cabillaud', TypeIngredient::POISSON],
            ['Sardine', TypeIngredient::POISSON],
            ['Maquereau', TypeIngredient::POISSON],
            ['Cumin', TypeIngredient::EPICE],
            ['Curcuma', TypeIngredient::EPICE],
            ['Paprika', TypeIngredient::EPICE],
            ['Curry', TypeIngredient::EPICE],
            ['Cannelle', TypeIngredient::EPICE],
            ['Riz', TypeIngredient::FECULENT],
            ['Pâtes', TypeIngredient::FECULENT],
            ['Quinoa', TypeIngredient::FECULENT],
            ['Boulgour', TypeIngredient::FECULENT],
            ['Pommes de terre', TypeIngredient::FECULENT],
            ['Pomme', TypeIngredient::FRUIT, [Season::AUTUMN]],
            ['Poire', TypeIngredient::FRUIT, [Season::AUTUMN]],
            ['Fraise', TypeIngredient::FRUIT, [Season::SPRING, Season::SUMMER]],
            ['Framboise', TypeIngredient::FRUIT, [Season::SUMMER]],
            ['Cerise', TypeIngredient::FRUIT, [Season::SUMMER]],
            ['Raisin', TypeIngredient::FRUIT, [Season::AUTUMN]],
            ['Orange', TypeIngredient::FRUIT, [Season::WINTER]],
            ['Banane', TypeIngredient::FRUIT],
            ['Kiwi', TypeIngredient::FRUIT, [Season::WINTER]],
            ['Melon', TypeIngredient::FRUIT, [Season::SUMMER]],
            ['Pastèque', TypeIngredient::FRUIT, [Season::SUMMER]],
            ['Mangue', TypeIngredient::FRUIT],
            ['Carotte', TypeIngredient::LEGUME, [Season::AUTUMN, Season::WINTER]],
            ['Courgette', TypeIngredient::LEGUME, [Season::SUMMER]],
            ['Aubergine', TypeIngredient::LEGUME, [Season::SUMMER]],
            ['Poivron', TypeIngredient::LEGUME, [Season::SUMMER]],
            ['Brocoli', TypeIngredient::LEGUME, [Season::WINTER]],
            ['Chou-fleur', TypeIngredient::LEGUME, [Season::WINTER]],
            ['Chou', TypeIngredient::LEGUME, [Season::WINTER]],
            ['Haricot vert', TypeIngredient::LEGUME, [Season::SUMMER]],
            ['Epinard', TypeIngredient::LEGUME, [Season::SPRING]],
            ['Salade', TypeIngredient::LEGUME, [Season::SPRING, Season::SUMMER]],
            ['Tomate', TypeIngredient::LEGUME, [Season::SUMMER]],
            ['Oignon', TypeIngredient::LEGUME],
            ['Ail', TypeIngredient::LEGUME],
            ['Lentilles', TypeIngredient::LEGUMINEUSE],
            ['Pois chiches', TypeIngredient::LEGUMINEUSE],
            ['Haricots rouges', TypeIngredient::LEGUMINEUSE],
            ['Haricots blancs', TypeIngredient::LEGUMINEUSE],
            ['Fèves', TypeIngredient::LEGUMINEUSE],
            ['Lait', TypeIngredient::PRODUIT_LAITIER],
            ['Fromage', TypeIngredient::PRODUIT_LAITIER],
            ['Yaourt', TypeIngredient::PRODUIT_LAITIER],
            ['Crème fraîche', TypeIngredient::PRODUIT_LAITIER],
            ['Beurre', TypeIngredient::PRODUIT_LAITIER],
            ['Huile d’olive', TypeIngredient::MATIERE_GRASSE],
            ['Huile de tournesol', TypeIngredient::MATIERE_GRASSE],
            ['Huile de colza', TypeIngredient::MATIERE_GRASSE],
            ['Saindoux', TypeIngredient::MATIERE_GRASSE],
            ['Sucre', TypeIngredient::PRODUIT_SUCRE],
            ['Miel', TypeIngredient::PRODUIT_SUCRE],
            ['Chocolat', TypeIngredient::PRODUIT_SUCRE],
            ['Confiture', TypeIngredient::PRODUIT_SUCRE],
            ['Eau', TypeIngredient::BOISSON],
            ['Jus d’orange', TypeIngredient::BOISSON],
            ['Café', TypeIngredient::BOISSON],
            ['Thé', TypeIngredient::BOISSON],
            ['Limonade', TypeIngredient::BOISSON],
            ['Vin rouge', TypeIngredient::BOISSON],
            ['Bière', TypeIngredient::BOISSON],
        ];

        foreach ($ingredients as $data) {
            $ingredient = new Ingredient();
            $ingredient->setName($data[0]);
            $ingredient->setTypeIngredient($data[1]);
            $ingredient->setSeason($data[2] ?? []);
            $manager->persist($ingredient);
        }


        $manager->flush();
    }
}
