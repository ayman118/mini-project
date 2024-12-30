<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function save(Product $product, bool $flush = false): void
    {
        $entityManager = $this->getEntityManager();
        $entityManager->persist($product);
        if ($flush) {
            $entityManager->flush();
        }
    }

    public function remove(Product $product, bool $flush = false): void
    {
        $entityManager = $this->getEntityManager();
        $entityManager->remove($product);
        if ($flush) {
            $entityManager->flush();
        }
    }

    public function findByName(string $name): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.name LIKE :name')
            ->setParameter('name', '%' . $name . '%')
            ->orderBy('p.name', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findByPriceRange(float $minPrice, float $maxPrice): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.price BETWEEN :minPrice AND :maxPrice')
            ->setParameter('minPrice', $minPrice)
            ->setParameter('maxPrice', $maxPrice)
            ->orderBy('p.price', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
