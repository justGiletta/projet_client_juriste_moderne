<?php

namespace App\Repository;

use App\Data\SearchData;
use App\Entity\OtherParticipant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OtherParticipant|null find($id, $lockMode = null, $lockVersion = null)
 * @method OtherParticipant|null findOneBy(array $criteria, array $orderBy = null)
 * @method OtherParticipant[]    findAll()
 * @method OtherParticipant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OtherParticipantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OtherParticipant::class);
    }

    public function findOtherSearch(SearchData $search, $id)
    {
        if (empty($search->getSearch())) {
            $queryBuilder = $this->createQueryBuilder('o')
                ->leftjoin('o.legalPerson', 'l')
                ->leftjoin('o.naturalPerson', 'n')
                ->leftjoin('l.structure', 'ls')
                ->leftJoin('n.structureMember', 'ns')
                ->andWhere('ls.id = :id OR ns.id = :id')
                ->andWhere('o.otherParticipantRole IS NOT NULL')
                ->setParameter('id', $id)
                ->getQuery();
        }
        if (!empty($search->getSearch())) {
            $queryBuilder = $this->createQueryBuilder('o')
                ->leftjoin('o.legalPerson', 'l')
                ->leftjoin('o.naturalPerson', 'n')
                ->leftjoin('l.structure', 'ls')
                ->leftJoin('n.structureMember', 'ns')
                ->andWhere('ls.id = :id OR ns.id = :id')
                ->andWhere('o.otherParticipantRole IS NOT NULL')
                ->andWhere('l.name LIKE :search OR n.lastname LIKE :search')
                ->setParameter('search', '%' . $search->getSearch() . '%')
                ->setParameter('id', $id)
                ->getQuery();
        }
        return $queryBuilder->getResult();
    }
}
