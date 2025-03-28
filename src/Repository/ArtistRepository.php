<?php

namespace App\Repository;

use App\Entity\Artist;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Artist>
 */
class ArtistRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Artist::class);
    }

    public function getDetails(int $id): array
    {
        return $this->createQueryBuilder('a')
            ->select('a.id AS id, a.name AS artistName, a.description, a.image, e.id AS eventId, e.name, e.date')
            ->leftJoin('a.events', 'e')
            ->where('a.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getArrayResult();
    }

    public function selectNameImage(): array
    {
        return $this->createQueryBuilder('a')
            ->select('a.id, a.name, a.image')
            ->getQuery()
            ->getArrayResult();
    }

    public function selectNameDescriptionImage(): array
    {
        return $this->createQueryBuilder('a')
            ->select('a.id, a.name, a.description')
            ->getQuery()
            ->getArrayResult();
    }

    //    /**
    //     * @return Artist[] Returns an array of Artist objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('a.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Artist
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
