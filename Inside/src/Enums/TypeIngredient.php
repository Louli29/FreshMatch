<?php
declare (strict_types=1);

namespace App\Enums;
enum TypeIngredient: string

{
    case VIANDE = 'viande';
    case POISSON = 'possion';
    case EPICE = 'epice';
    case FECULENT = 'feculent';
    case FRUIT = 'fruit';
    case LEGUMINEUSE = 'legumineuse';
    case LEGUME = 'legume';
    case PRODUIT_LAITIER = 'produit_laitier';
    case MATIERE_GRASSE = 'matiere_grasse';
    case PRODUIT_SUCRE = 'produit_sucre';
    case BOISSON = 'boisson';
}

?>