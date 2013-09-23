<?php

namespace Pimx\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ReportController extends Controller {

    public function financeAction() {
        $manager = $this->getDoctrine()->getManager();

        $sqlQuery = "
            SELECT
                    date_format(movimientos.mov_FecHora, '%Y-%m') AS Month,
                    sum((cuentasxmovim.cxm_Sentido * cuentasxmovim.cxm_Importe)) AS Balance
            FROM
                    (movimientos
                    join cuentasxmovim ON ((cuentasxmovim.cxmmov_ID = movimientos.mov_ID)))
            WHERE
                    (mov_FecHora >= (now() + interval -(:last_months) month))
            GROUP BY date_format(movimientos.mov_FecHora, '%Y %m')
            ORDER BY movimientos.mov_FecHora DESC";

//        $resultSet = new \Doctrine\ORM\Query\ResultSetMapping;
//        $query = $manager->createNativeQuery($sqlQuery, $resultSet);
//        $query->setParameter('last_months', 48);
//        $months_balance = $query->getResult();
        $stmt = $manager->getConnection()->prepare($sqlQuery);
        $stmt->bindValue('last_months', 12);
        $stmt->execute();
        $months_balance = $stmt->fetchAll();

        return $this->render('PimxFrontendBundle:Report:finance.html.twig', array('months_balance' => $months_balance));
    }

}
