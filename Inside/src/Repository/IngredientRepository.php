<?php

namespace App\Repository;

use App\Entity\Ingredient;
use App\Entity\User;


use App\Enums\TypeIngredient;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Ingredient>
 */
class IngredientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ingredient::class);
    }
    
    public function findSeasonIngredients($saison)
    {
        return $this->createQueryBuilder('i')
            ->where('i.season LIKE :saison')
            ->setParameter('saison', '%'.$saison.'%' )
            ->getQuery()
            ->getResult();
    }

    public function findByTypeIngredient(string $type): array
    {
        $typeEnum = TypeIngredient::tryFrom($type);
        if (!$typeEnum) {
            throw new \InvalidArgumentException("Type d'ingrédient invalide : $type");
        }

        return $this->createQueryBuilder('i')
            ->where('i.typeIngredient = :type')
            ->setParameter('type', $typeEnum)
            ->getQuery()
            ->getResult();
    }



    //    /**
    //     * @return Ingredient[] Returns an array of Ingredient objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('i')
    //            ->andWhere('i.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('i.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Ingredient
    //    {
    //        return $this->createQueryBuilder('i')
    //            ->andWhere('i.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
