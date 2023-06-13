<?php

namespace App\Repository;

use App\Classe\Search;
use App\Entity\ShopProduct;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @extends ServiceEntityRepository<ShopProduct>
 *
 * @method ShopProduct|null find($id, $lockMode = null, $lockVersion = null)
 * @method ShopProduct|null findOneBy(array $criteria, array $orderBy = null)
 * @method ShopProduct[]    findAll()
 * @method ShopProduct[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShopProductRepository extends ServiceEntityRepository
{
    /**
     * @var PaginatorInterface
     */

     private $paginator;

    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator)
    {
        parent::__construct($registry, ShopProduct::class);
        $this->paginator = $paginator;
    }

    public function save(ShopProduct $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ShopProduct $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Récupère le prix minimum et maximum correspondant a une recherche
     * @param Search $search
     * @return interger[]
     */
    public function findMinMax(Search $search): array
    {
        return [0, 50000];
    }

    /**
     * Requête qui permet de récuperer les product en fonction de la recherche de l'utilisateur
     * @return PaginationInterface
     */

    public function findWithSearch (Search $search): PaginationInterface
    {
        $query = $this
             ->createQueryBuilder('s')
             ->select('SubCategory', 's')
             ->join('s.SubCategory', 'SubCategory');


             if (!empty($search->SubCategory)) {
                $query = $query
                    ->andWhere('SubCategory.id in (:SubCategory)')
                    ->setParameter('SubCategory', $search->SubCategory);
             }

             
        if (!empty($search->q)) {
            $query = $query 
                ->andWhere('s.subtitle LIKE :q')
                    ->setParameter('q','%'.$search->q.'%');
        }
        if (!empty($search->min)) {
            $query = $query 
                ->andWhere('s.price >= :min')
                    ->setParameter('min','%'.$search->min.'%');
        }
        if (!empty($search->max)) {
            $query = $query 
                ->andWhere('s.price <= :max')
                    ->setParameter('max','%'.$search->max.'%');
        }

        if (!empty($search->promo)) {
            $query = $query 
                ->andWhere('s.statut = 1');
        }

            $query = $query->getQuery();
            return $this->paginator->paginate(
                $query,
                $search->page,
                50,

            );

            
    }
  
    public function paginationQuery()
    {
       return $this->createQueryBuilder('s')
            ->orderBy('s.id', 'ASC')
            ->getQuery()
       ;
   }

//    public function findOneBySomeField($value): ?ShopProduct
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
