<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    // /**
    //  * @return Product[] Returns an array of Product objects
    //  */
    public function findByTitle($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.title = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return Product Returns a list of products where quantity != null
     */
    public function findByQuantityNotNull()
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.quantity > 0')
            ->orderBy('p.quantity', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    
    public function findBySearch($elementDeRecherche)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.title LIKE :val')
            ->setParameter('val', '%'.$elementDeRecherche.'%')
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

}
