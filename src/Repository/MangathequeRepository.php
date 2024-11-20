<?php

namespace App\Repository;

use App\Entity\Mangatheque;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Mangatheque>
 */
class MangathequeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Mangatheque::class);
    }

    public function findPublicMangatheques(): array
    {
        return $this->findBy(['publiee' => true]);
    }

}
