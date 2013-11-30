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

        return $queryBulder->getQuery()->getResult();
    }

}