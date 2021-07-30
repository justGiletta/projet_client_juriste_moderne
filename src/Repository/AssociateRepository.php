<?php

namespace App\Repository;

use App\Data\SearchData;
use App\Entity\Associate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Associate|null find($id, $lockMode = null, $lockVersion = null)
 * @method Associate|null findOneBy(array $criteria, array $orderBy = null)
 * @method Associate[]    findAll()
 * @method Associate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AssociateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Associate::class);
    }

    public function findAncienAssoSearch(SearchData $search, $id)
    {
        if (empty($search->getSearch())) {
            $queryBuilder = $this->createQueryBuilder('a')
                ->leftJoin('a.legalPerson', 'l')
                ->leftJoin('a.naturalPerson', 'n')
                ->leftJoin('l.structure', 'ls')
                ->leftJoin('n.structureMember', 'ns')
                ->where('DATE_DIFF(a.withdrawalRequestDate, CURRENT_DATE() ) <= 0')
                ->andWhere('a.subscriptionDate IS NOT NULL')
                ->andWhere('ls.id = :id OR ns.id = :id')
                ->setParameter('id', $id)
                ->getQuery();
        }
        if (!empty($search->getSearch())) {
            $queryBuilder = $this->createQueryBuilder('a')
                ->leftJoin('a.legalPerson', 'l')
                ->leftJoin('a.naturalPerson', 'n')
                ->leftJoin('l.structure', 'ls')
                ->leftJoin('n.structureMember', 'ns')
                ->where('DATE_DIFF(a.withdrawalRequestDate, CURRENT_DATE() ) <= 0')
                ->andWhere('a.subscriptionDate IS NOT NULL')
                ->andWhere('ls.id = :id OR ns.id = :id')
                ->andWhere('l.name LIKE :search OR n.lastname LIKE :search')
                ->setParameter('id', $id)
                ->setParameter('search', '%' . $search->getSearch() . '%')
                ->getQuery();
        }
        return $queryBuilder->getResult();
    }

    public function findAssoSorSearch(SearchData $search, $id)
    {
        if (empty($search->getSearch())) {
            $queryBuilder = $this->createQueryBuilder('a')
                ->leftJoin('a.legalPerson', 'l')
                ->leftJoin('a.naturalPerson', 'n')
                ->leftJoin('l.structure', 'ls')
                ->leftJoin('n.structureMember', 'ns')
                ->where('DATE_DIFF(a.withdrawalRequestDate, CURRENT_DATE() ) > 0')
                ->andWhere('a.subscriptionDate IS NOT NULL')
                ->andWhere('ls.id = :id OR ns.id = :id')
                ->setParameter('id', $id)
                ->getQuery();
        }
        if (!empty($search->getSearch())) {
            $queryBuilder = $this->createQueryBuilder('a')
                ->leftJoin('a.legalPerson', 'l')
                ->leftJoin('a.naturalPerson', 'n')
                ->leftJoin('l.structure', 'ls')
                ->leftJoin('n.structureMember', 'ns')
                ->where('DATE_DIFF(a.withdrawalRequestDate, CURRENT_DATE() ) > 0')
                ->andWhere('ls.id = :id OR ns.id = :id')
                ->andWhere('a.subscriptionDate IS NOT NULL')
                ->andWhere('l.name LIKE :search OR n.lastname LIKE :search')
                ->setParameter('search', '%' . $search->getSearch() . '%')
                ->setParameter('id', $id)
                ->getQuery();
        }
        return $queryBuilder->getResult();
    }
    public function findAssoSearch(SearchData $search, $id)
    {
        if (empty($search->getSearch())) {
            $queryBuilder = $this->createQueryBuilder('a')
                ->leftJoin('a.legalPerson', 'l')
                ->leftJoin('a.naturalPerson', 'n')
                ->leftJoin('l.structure', 'ls')
                ->leftJoin('n.structureMember', 'ns')
                ->where('a.withdrawalRequestDate IS NULL')
                ->andWhere('ls.id = :id OR ns.id = :id')
                ->andWhere('a.subscriptionDate IS NOT NULL')
                ->setParameter('id', $id)
                ->getQuery();
        }
        if (!empty($search->getSearch())) {
            $queryBuilder = $this->createQueryBuilder('a')
                ->leftJoin('a.legalPerson', 'l')
                ->leftJoin('a.naturalPerson', 'n')
                ->leftJoin('l.structure', 'ls')
                ->leftJoin('n.structureMember', 'ns')
                ->where('a.withdrawalRequestDate IS NULL')
                ->andWhere('ls.id = :id OR ns.id = :id')
                ->andWhere('a.subscriptionDate IS NOT NULL')
                ->andWhere('l.name LIKE :search OR n.lastname LIKE :search')
                ->setParameter('search', '%' . $search->getSearch() . '%')
                ->setParameter('id', $id)
                ->getQuery();
        }

        return $queryBuilder->getResult();
    }
}
