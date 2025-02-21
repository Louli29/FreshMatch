<?php
declare(strict_types = 1);
namespace App\Enums;

enum Allergy : string {

    case GLUTEN = 'vegetarien';
    case LACTOSE = 'vegan';
    case FRUIT_A_COQUE = 'fruit a coque';
    case FRUIT_DE_MER = 'fruit de mer';
}

?>
