<?php

namespace App\Repository;

use App\Data\SearchData;
use App\Entity\Associate;
use App\Entity\LegalPerson;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method LegalPerson|null find($id, $lockMode = null, $lockVersion = null)
 * @method LegalPerson|null findOneBy(array $criteria, array $orderBy = null)
 * @method LegalPerson[]    findAll()
 * @method LegalPerson[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LegalPersonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LegalPerson::class);
    }


    public function findByPers(int $id)
    {
        $queryBuilder = $this->createQueryBuilder('l')
            ->where('ls.id = :id')
            ->join('l.structure', 'ls')
            ->orderBy('l.id', 'DESC')
            ->setParameter('id', $id)
            ->getQuery();

        return $queryBuilder->getResult();
    }

    public function findLegalBy(int $id)
    {
        $queryBuilder = $this->createQueryBuilder('l')
            ->where('ls.id = :id')
            ->join('l.structure', 'ls')
            ->orderBy('l.id', 'DESC')
            ->setParameter('id', $id);

        return $queryBuilder;
    }

    public function findSearch(SearchData $search, int $id)
    {
        $queryBuilder = $this->createQueryBuilder('l')
            ->where('ls.id = :id')
            ->join('l.structure', 'ls')
            ->andWhere('l.name LIKE :search')
            ->orderBy('l.id', 'DESC')
            ->setParameter('search', '%' . $search->getSearch() . '%')
            ->setParameter('id', $id)
            ->getQuery();

        return $queryBuilder->getResult();
    }
}
