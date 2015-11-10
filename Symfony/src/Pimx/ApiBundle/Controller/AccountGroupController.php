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

use Pimx\ModelBundle\Entity\AccountGroup;

/**
 * @RouteResource("AccountGroup", pluralize=false)
 */
class AccountGroupController extends /*Controller*/ FOSRestController implements ClassResourceInterface {

    /**
     * @Rest\View
	 */
    public function cgetAction() {
        $groups = $this->getDoctrine()
                ->getRepository('PimxModelBundle:AccountGroup')
                ->findAll()
        ;

        return $groups;
    }

    /**
     * @Rest\View
	 */
    public function getAction($code) {
        $accountGroup = $this->getDoctrine()
                ->getRepository('PimxModelBundle:AccountGroup')
                ->find($code)
        ;
        
        if (!$accountGroup instanceof AccountGroup) {
            throw new NotFoundHttpException('Account Group not found');
        }

        return $accountGroup;
    }

    /**
     * @Rest\View
	 */
    public function postAction(Request $request) {
        return array('result' => 'OK');
    }
}
