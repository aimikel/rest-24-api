<?php

namespace App\Repository;

use App\Entity\ImportFileReference;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ImportFileReferenceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ImportFileReference::class);
    }

    public function findAll()
    {
        return parent::findAll();
    }

    public function findImportFileReferenceByName(string $name)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.name = :val')
            ->setParameter('val', $name)
            ->getQuery()
            ->getOneOrNullResult();
    }

}