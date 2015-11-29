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

use Pimx\ModelBundle\Entity\MovementGroup;

/**
 * @RouteResource("MovementGroup", pluralize=false)
 */
class MovementGroupController extends /*Controller*/ FOSRestController implements ClassResourceInterface {

    /**
     * @Rest\View
	 */
    public function cgetAction() {
        $groups = $this->getDoctrine()
                ->getRepository('PimxModelBundle:MovementGroup')
                ->findAll()
        ;

        return $groups;
    }

    /**
     * @Rest\View
	 */
    public function getAction($code) {
        $MovementGroup = $this->getDoctrine()
                ->getRepository('PimxModelBundle:MovementGroup')
                ->find($code)
        ;
        
        if (!$MovementGroup instanceof MovementGroup) {
            throw new NotFoundHttpException('Movement Group not found');
        }

        return $MovementGroup;
    }

    /**
     * @Rest\View
	 */
    public function postAction(Request $request) {
        return array('result' => 'OK');
    }
}
