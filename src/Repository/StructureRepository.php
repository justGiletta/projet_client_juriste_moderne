<?php

namespace App\Repository;

use App\Entity\Structure;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Structure|null find($id, $lockMode = null, $lockVersion = null)
 * @method Structure|null findOneBy(array $criteria, array $orderBy = null)
 * @method Structure[]    findAll()
 * @method Structure[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StructureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Structure::class);
    }

    public function findStructureBy(int $id)
    {
        $queryBuilder = $this->createQueryBuilder('user', 'u')
            ->where('us.id = :id')
            ->join('u.structure', 'us')
            ->orderBy('u.id', 'DESC')
            ->setParameter('id', $id);

        return $queryBuilder;
    }
}
