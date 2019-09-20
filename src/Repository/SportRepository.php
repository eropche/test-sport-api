<?php

namespace App\Repository;

use App\Entity\Sport;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Sport|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sport|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sport[]    findAll()
 * @method Sport[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SportRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sport::class);
    }
    
    public function save(Sport $sport)
    {
        $this->getEntityManager()->persist($sport);
        $this->getEntityManager()->flush();
    }
    
    public function update(Sport $sport)
    {
        $this->getEntityManager()->merge($sport);
        $this->getEntityManager()->flush();
    }

    public function findByLikeName($name)
    {
        return $this->createQueryBuilder('s')
            ->where('LOWER(s.name) LIKE :name')
            ->setParameter('name', '%'.mb_strtolower($name).'%')
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    // /**
    //  * @return Sport[] Returns an array of Sport objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Sport
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}