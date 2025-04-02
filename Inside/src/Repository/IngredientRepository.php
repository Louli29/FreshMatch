<?php

namespace App\Repository;

use App\Entity\Ingredient;
use App\Entity\User;


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

    public function findIngredientsByUser(User $user): array
    {
        $qb = $this->createQueryBuilder('i')
            ->select('i.name')
            ->innerJoin('i.listIngrUsers', 'lu')
            ->where('lu.user = :user')
            ->setParameter('user', $user);

        return array_column($qb->getQuery()->getResult(), 'name');
    }



    public function findDistinctIngredientTypes(): array
    {
        return $this->createQueryBuilder('i')
            ->select('DISTINCT i.typeIngredient')
            ->getQuery()
            ->getSingleColumnResult();
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
