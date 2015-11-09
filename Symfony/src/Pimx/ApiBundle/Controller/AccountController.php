<?php

namespace Pimx\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Controller\Annotations\ApiDoc;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use FOS\RestBundle\Routing\ClassResourceInterface;

use Pimx\ModelBundle\Entity\Account;

/**
 * @RouteResource("Account", pluralize=false)
 */
class AccountController extends Controller /*FOSRestController*/ implements ClassResourceInterface {

    public function cgetAction() {
        $accounts = $this->getDoctrine()
                ->getRepository('PimxModelBundle:Account')
                ->findAll()
        ;

        return array('accounts' => $accounts);
    }

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

    public function postAction(Request $request) {
        return array('result' => 'OK');
    }
}
