<?php

namespace Pimx\ApiBundle\Controller;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

use Pimx\ModelBundle\Entity\Account;

class AccountController extends FOSRestController {

    /**
     * @Rest\View
     */
    public function allAction() {
        $accounts = $this->getDoctrine()
                ->getRepository('PimxModelBundle:Account')
                ->findAll()
        ;

        return array('accounts' => $accounts);
    }

    /**
     * @Rest\View
     */
    public function getAction($code) {
        $account = $this->getDoctrine()
                ->getRepository('PimxModelBundle:Account')
                ->find($code)
        ;
        
        if (!$account instanceof Account) {
            throw new NotFoundHttpException('Account not found');
        }

        return array('account' => $account);
    }

}
