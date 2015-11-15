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
use Pimx\ApiBundle\Form\Type\AccountType;

/**
 * @RouteResource("Account", pluralize=false)
 */
class AccountController extends /*Controller*/ FOSRestController implements ClassResourceInterface {

    /**
     * @Rest\View
	 */
    public function cgetAction() {
        $accounts = $this->getDoctrine()
                ->getRepository('PimxModelBundle:Account')
                ->findAll()
        ;

        return $accounts;
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

        return $account;
    }

    
    /**
     * @Rest\View
	 */
    public function postAction(Request $request) {
		$account = new Account();
		$form = $this->createForm(new AccountType(), $account, array("method" => "POST"));
		$form->handleRequest($request);
		//$form->submit($request);
		
		if($form->isValid()){
			$account = $form->getData();
			print_r($account); die();
			return array('result' => 'OK');
		}
		print_r($form->getErrors());die();
        return $form;
    }

    /**
     * @Rest\View
	 */
    public function putAction(Request $request, $code) {
		$account = new Account();
		$form = $this->createForm(new AccountType(), $account, array("method" => "PUT"));
		$form->handleRequest($request);
		//$form->submit(null);
		
		if($form->isValid()){
			$account = $form->getData();
			//print_r($account); die();
			return array('result' => 'OK');
		}
		
        return $form;
    }
	
}
