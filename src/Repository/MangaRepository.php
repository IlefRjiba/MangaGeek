<?php

namespace App\Repository;

use App\Entity\Manga;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Member;

/**
 * @extends ServiceEntityRepository<Manga>
 */
class MangaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Manga::class);
    }

    /**
     * @return Manga[] Returns an array of Manga objects for a member
     */
    public function findMemberManga(Member $member): array
    {
            return $this->createQueryBuilder('o')
                    ->leftJoin('o.mangashelf', 'i')
                    ->andWhere('i.membre = :member')
                    ->setParameter('member', $member)
                    ->getQuery()
                    ->getResult()
            ;
    }
    
}
