<?php

namespace Pimx\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ReportController extends Controller {

    public function financeAction() {
        $manager = $this->getDoctrine()->getManager();
        $connection = $manager->getConnection();

        $months_balance = $this->getMonthBalanceResult($connection);
        $accounts_balance = $this->getAccountBalanceResult($connection);

        return $this->render('PimxFrontendBundle:Report:finance.html.twig', array(
            'months_balance' => $months_balance,
            'accounts_balance' => $accounts_balance
            ));
    }
    
    private function getMonthBalanceResult($connection) {
        $sqlQuery = "
            SELECT
                    date_format(mov_FecHora, '%Y-%m') AS Month,
                    SUM(CASE WHEN MovAmount > 0 THEN MovAmount ELSE 0 END) AS Income,
                    SUM(CASE WHEN MovAmount < 0 THEN MovAmount ELSE 0 END) AS Outcome,
                    SUM(MovAmount) AS Balance
            FROM  (SELECT mov_ID, mov_FecHora, 
                        SUM(cxm_Sentido * cxm_Importe) AS MovAmount
                    FROM movimientos
                        INNER JOIN cuentasxmovim ON cxmmov_ID = movimientos.mov_ID
                    WHERE (mov_FecHora >= (now() + interval -(:last_months) month))
                    GROUP BY mov_ID, mov_FecHora
                    ) AS MovimsGroup
            GROUP BY date_format(mov_FecHora, '%Y %m')
            ORDER BY mov_FecHora DESC";

        $stmt = $connection->prepare($sqlQuery);
        $stmt->bindValue('last_months', 12);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    private function getAccountBalanceResult($connection) {
        $sqlQuery = "
            SELECT 
                    cta_cod AS Account_Cod,
                    cta_Desc AS Account_Description,
                    SUM(cxm_Importe * cxm_Sentido) + cta_SaldoInicial AS Balance
            FROM cuentas
                    INNER JOIN cuentasxmovim ON cxmcta_cod = cta_cod
            GROUP BY cta_cod, cta_Desc";

        $stmt = $connection->prepare($sqlQuery);
        $stmt->execute();
        return $stmt->fetchAll();
    }

}
