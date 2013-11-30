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
                ->setFirstResult($paginator->getOffset())
                ->setMaxResults($paginator->getPageSize())
                ->orderBy('mov.date', 'DESC');

        if (isset($filters['date_start'])) {
            $queryBulder->where('mov.date >= :date_start');
            $queryBulder->setParameter('date_start', $filters['date_start']);
        }
        if (isset($filters['date_end']) ) {
            $queryBulder->where('mov.date <= :date_end');
            $queryBulder->setParameter('date_end', $filters['date_end']);
        }
        if (isset($filters['acc_cod']) ) {
            $queryBulder->where('movacc.account = :account_cod');
            $queryBulder->setParameter('account_cod', $filters['acc_cod']);
        }

        return $queryBulder->getQuery()->getResult();
    }

}