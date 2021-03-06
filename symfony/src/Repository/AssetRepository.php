<?php
namespace App\Repository;

use App\Entity\Asset;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class AssetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Asset::class);
    }

    public function findAll()
    {
        return parent::findAll();
    }

    public function findOneByName(string $name): ?Asset
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.name = :val')
            ->setParameter('val', $name)
            ->getQuery()
            ->getOneOrNullResult();
    }


}