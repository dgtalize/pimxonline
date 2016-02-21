<?php

namespace Pimx\ModelBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Pimx\ModelBundle\Pagination\Paginator;

class MovementRepository extends EntityRepository {

    /**
     * @return array Results
     */
    public function findByFilters(Paginator $paginator, array $filters) {
        $qryBulder = $this->createQueryBuilder('mov')
                ->innerJoin('mov.appliedAccounts', 'movacc')
                ->orderBy('mov.date', 'DESC');

        if (isset($filters['date_start'])) {
            $qryBulder->andWhere('mov.date >= :date_start');
            $qryBulder->setParameter('date_start', $filters['date_start']);
        }
        if (isset($filters['date_end'])) {
            $qryBulder->andWhere('mov.date <= :date_end');
            $qryBulder->setParameter('date_end', $filters['date_end']);
        }
        if (isset($filters['acc_cod'])) {
            $qryBulder->andWhere('movacc.account = :account_cod');
            $qryBulder->setParameter('account_cod', $filters['acc_cod']);
        }
        if (isset($filters['freetext'])) {
            $likeCriteria = '%'.$filters['freetext'].'%';
            $qryBulder->andWhere($qryBulder->expr()->orX(
                    $qryBulder->expr()->like('mov.name', $qryBulder->expr()->literal($likeCriteria)),
                    $qryBulder->expr()->like('mov.notes', $qryBulder->expr()->literal($likeCriteria))
            ));
//            $qryBulder->setParameter('freetext', $filters['freetext']);
        }

        $finalQuery = $this->getEntityManager()
                ->createQuery($qryBulder->getDQL())
                ->setParameters($qryBulder->getParameters())
                ->setFirstResult($paginator->getOffset())
                ->setMaxResults($paginator->getPageSize())
        ;

        return $finalQuery->getResult();
    }
    
    public function findLatest($days) {
        $qryBulder = $this->createQueryBuilder('mov')
                ->orderBy('mov.date', 'DESC');

        $qryBulder->andWhere('mov.date >= :date_from');
        $qryBulder->setParameter('date_from', strtotime(date('Y-m-d H:i:s') . " -$days days"));

        return $qryBulder->getQuery()->getResult();
    }

}