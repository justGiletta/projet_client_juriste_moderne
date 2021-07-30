<?php

namespace App\Repository;

use App\Data\SearchData;
use App\Entity\NaturalPerson;
use App\Entity\Structure;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method NaturalPerson|null find($id, $lockMode = null, $lockVersion = null)
 * @method NaturalPerson|null findOneBy(array $criteria, array $orderBy = null)
 * @method NaturalPerson[]    findAll()
 * @method NaturalPerson[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NaturalPersonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NaturalPerson::class);
    }

    public function findByPers(int $id)
    {
        return $this->createQueryBuilder('n')
            ->where('ns.id = :id')
            ->join('n.structureMember', 'ns')
            ->orderBy('n.id', 'DESC')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
    }


    public function findNaturalBy(int $id)
    {
        $queryBuilder = $this->createQueryBuilder('n')
            ->where('ns.id = :id')
            ->join('n.structureMember', 'ns')
            ->orderBy('n.id', 'DESC')
            ->setParameter('id', $id);

        return $queryBuilder;
    }

    public function findSearch(SearchData $search, int $id)
    {
        $queryBuilder = $this->createQueryBuilder('n')
            ->where('s.id = :id')
            ->join('n.structureMember', 's')
            ->andWhere('n.lastname LIKE :search')
            ->orderBy('n.id', 'DESC')
            ->setParameter('search', '%' . $search->getSearch() . '%')
            ->setParameter('id', $id)
            ->getQuery();

        return $queryBuilder->getResult();
    }
}
