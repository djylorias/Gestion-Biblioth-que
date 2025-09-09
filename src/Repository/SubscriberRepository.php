<?php

namespace App\Repository;

use App\Entity\Subscriber;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * @extends ServiceEntityRepository<Subscriber>
 */
class SubscriberRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Subscriber::class);
    }

    public function getPaginatedSubscribers(int $page, int $limit, ?string $search): Paginator
    {
        if ($search) {
            return new Paginator($this
                ->createQueryBuilder('s')
                ->where('s.firstname LIKE :search OR s.lastname LIKE :search')
                ->setParameter('search', '%' . $search . '%')
                ->orderBy('s.firstname', 'ASC')
                ->orderBy('s.lastname', 'ASC')
                ->setFirstResult(($page - 1) * $limit)
                ->setMaxResults($limit),
                false
            );
        } else {
            return new Paginator($this
                ->createQueryBuilder('s')
                ->orderBy('s.firstname', 'ASC')
                ->orderBy('s.lastname', 'ASC')
                ->setFirstResult(($page - 1) * $limit)
                ->setMaxResults($limit),
                false
            );
        }
    }

//    /**
//     * @return Subscriber[] Returns an array of Subscriber objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Subscriber
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
