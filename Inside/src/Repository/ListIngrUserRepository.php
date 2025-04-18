<?php

namespace App\Repository;

use App\Entity\ListIngrUser;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ListIngrUser>
 */
class ListIngrUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ListIngrUser::class);
    }

    public function findUserPantryIngredients(User $user): array
    {
        $qb = $this->createQueryBuilder('lu')
            ->select('i.name')
            ->innerJoin('lu.ingredient', 'i')
            ->where('lu.user = :user')
            ->setParameter('user', $user);

        return array_column($qb->getQuery()->getResult(), 'name');
    }


    //    /**
    //     * @return ListIngrUserService[] Returns an array of ListIngrUserService objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('l')
    //            ->andWhere('l.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('l.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?ListIngrUserService
    //    {
    //        return $this->createQueryBuilder('l')
    //            ->andWhere('l.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
