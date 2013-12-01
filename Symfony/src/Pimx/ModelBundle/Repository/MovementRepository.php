<?php

namespace Pimx\ModelBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Pimx\ModelBundle\Pagination\Paginator;

class MovementRepository extends EntityRepository {

    /**
     * @return array Results
     */
    public function findByFilters(Paginator $paginator, array $filters) {
        $queryBulder = $this->createQueryBuilder('mov')
                ->innerJoin('mov.appliedAccounts', 'movacc')
                ->orderBy('mov.date', 'DESC');

        if (isset($filters['date_start'])) {
            $queryBulder->andWhere('mov.date >= :date_start');
            $queryBulder->setParameter('date_start', $filters['date_start']);
        }
        if (isset($filters['date_end'])) {
            $queryBulder->andWhere('mov.date <= :date_end');
            $queryBulder->setParameter('date_end', $filters['date_end']);
        }
        if (isset($filters['acc_cod'])) {
            $queryBulder->andWhere('movacc.account = :account_cod');
            $queryBulder->setParameter('account_cod', $filters['acc_cod']);
        }

        $finalQuery = $this->getEntityManager()
                        ->createQuery($queryBulder->getDQL())
                        ->setParameters($queryBulder->getParameters())
                        ->setFirstResult($paginator->getOffset())
                        ->setMaxResults($paginator->getPageSize())
                ;

        return $finalQuery->getResult();
    }

}