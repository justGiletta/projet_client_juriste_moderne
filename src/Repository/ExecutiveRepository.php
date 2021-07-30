<?php

namespace App\Repository;

use App\Data\SearchData;
use App\Entity\Executive;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Executive|null find($id, $lockMode = null, $lockVersion = null)
 * @method Executive|null findOneBy(array $criteria, array $orderBy = null)
 * @method Executive[]    findAll()
 * @method Executive[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExecutiveRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Executive::class);
    }

    public function findExeSearch(SearchData $search, $id)
    {
        if (empty($search->getSearch())) {
            $queryBuilder = $this->createQueryBuilder('e')
                ->leftjoin('e.legalPerson', 'l')
                ->leftjoin('e.naturalPerson', 'n')
                ->leftjoin('l.structure', 'ls')
                ->leftJoin('n.structureMember', 'ns')
                ->andWhere('ls.id = :id OR ns.id = :id')
                ->andWhere('e.mandateType IS NOT NULL')
                ->setParameter('id', $id)
                ->getQuery();
        }
        if (!empty($search->getSearch())) {
            $queryBuilder = $this->createQueryBuilder('e')
                ->leftjoin('e.legalPerson', 'l')
                ->leftjoin('e.naturalPerson', 'n')
                ->leftjoin('l.structure', 'ls')
                ->leftJoin('n.structureMember', 'ns')
                ->andWhere('ls.id = :id OR ns.id = :id')
                ->andWhere('e.mandateType IS NOT NULL')
                ->andWhere('l.name LIKE :search OR n.lastname LIKE :search')
                ->setParameter('id', $id)
                ->setParameter('search', '%' . $search->getSearch() . '%')
                ->getQuery();
        }
        return $queryBuilder->getResult();
    }
}
