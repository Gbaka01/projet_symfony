<?php

namespace App\Repository;

use App\Entity\Recette;
use App\Repository\RecetteRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Recette>
 */
class RecetteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Recette::class);
    }
         /**
        * @return Recette[] Returns an array of Recette objects
        */
// src/Repository/RecetteRepository.php

public function findByName(?string $fiche): array
{
    $qb = $this->createQueryBuilder('r');

    if ($fiche) {
        $qb->andWhere('r.nom LIKE :fiche')
           ->setParameter('fiche', '%' . $fiche . '%');
    }

    return $qb->orderBy('r.id', 'DESC')
              ->getQuery()
              ->getResult();
}



    //    /**
    //     * @return Recette[] Returns an array of Recette objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('r.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Recette
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
