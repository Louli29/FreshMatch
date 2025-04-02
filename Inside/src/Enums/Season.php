<?php
declare (strict_types=1);
namespace App\Enums;

enum Season: string
{
    case SPRING = 'SPRING';
    case SUMMER = 'SUMMER';
    case AUTUMN = 'AUTUMN';
    case WINTER = 'WINTER';

    public function getDates(int $year): array // La méthode récupère la date associée au saison en fonction du $this qui est l'une des 4 saisons
    { 
        return match ($this) { // match c'est comme Switch en PHP
            self::SPRING => ['start' => "$year-03-21", 'end' => "$year-06-20"],
            self::SUMMER => ['start' => "$year-06-21", 'end' => "$year-09-22"],
            self::AUTUMN => ['start' => "$year-09-23", 'end' => "$year-12-20"],
            self::WINTER => ['start' => "$year-12-21", 'end' => ($year + 1) . "-03-20"], // Year+1 car l'hiver se repose sur deux années
        };
    }

}

?>