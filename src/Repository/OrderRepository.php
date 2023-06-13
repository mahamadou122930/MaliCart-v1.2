<?php

namespace App\Repository;

use App\Entity\Order;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Order>
 *
 * @method Order|null find($id, $lockMode = null, $lockVersion = null)
 * @method Order|null findOneBy(array $criteria, array $orderBy = null)
 * @method Order[]    findAll()
 * @method Order[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Order::class);
    }

   /**
    * Find carts that have not been modified since the given date.
    * 
    * @return int|mixed|string
    */
    public function findCartNotModifiedSince(\DateTime $limitDate, int $limit = 10): array
    {
        return $this->createQueryBuilder('o')
        ->andWhere('o.status = :status')
        ->andWhere('o.updatedAt < :date')
        ->setParameter('status', Order::STATUS_CART)
        ->setParameter('date', $limitDate)
        ->setMaxResults($limit)
        ->getQuery()
        ->getResult();
    }

}