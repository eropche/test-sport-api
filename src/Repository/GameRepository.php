<?php

namespace App\Repository;

use App\Entity\Game;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Game|null find($id, $lockMode = null, $lockVersion = null)
 * @method Game|null findOneBy(array $criteria, array $orderBy = null)
 * @method Game[]    findAll()
 * @method Game[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GameRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Game::class);
    }
    
    public function getCount(?string $querySource, ?string $queryMatchDateFrom, ?string $queryMatchDateTo)
    {
        $qb = $this->createQueryBuilder('g')->select('count(g.id)');
        if ($querySource !== null) {
            $qb->andWhere('g.source = :source')->setParameter('source', $querySource);
        }
        if ($queryMatchDateFrom !== null) {
            $queryMatchDateFrom = new \DateTime($queryMatchDateFrom);
            $qb->andWhere('g.matchDate >= :matchDateFrom')->setParameter(':matchDateFrom', $queryMatchDateFrom);
        }
        if ($queryMatchDateTo !== null) {
            $queryMatchDateTo = new \DateTime($queryMatchDateTo);
            $qb->andWhere('g.matchDate <= :matchDateTo')->setParameter(':matchDateTo', $queryMatchDateTo);
        }
        
        return $qb->getQuery()->getSingleScalarResult();
    }

    // /**
    //  * @return Game[] Returns an array of Game objects
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
    public function findOneBySomeField($value): ?Game
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
