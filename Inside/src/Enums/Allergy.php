<?php
declare(strict_types = 1);
namespace App\Enums;

enum Allergy : string {

    case GLUTEN = 'Gluten';
    case LACTOSE = 'Lactose';
    case FRUIT_A_COQUE = 'Fruit à coque';
    case FRUIT_DE_MER = 'Fruit de mer';
}

?>
