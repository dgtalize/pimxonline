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

use Pimx\ModelBundle\Entity\MovementType;

/**
 * @RouteResource("MovementType", pluralize=false)
 */
class MovementTypeController extends FOSRestController implements ClassResourceInterface {

    /**
     * @Rest\View
	 */
    public function cgetAction() {
        $types = $this->getDoctrine()
                ->getRepository('PimxModelBundle:MovementType')
                ->findAll()
        ;

        return $types;
    }

    /**
     * @Rest\View
	 */
    public function getAction($code) {
        $accountType = $this->getDoctrine()
                ->getRepository('PimxModelBundle:MovementType')
                ->find($code)
        ;
        
        if (!$accountType instanceof MovementType) {
            throw new NotFoundHttpException('Movement Type not found');
        }

        return $accountType;
    }

    /**
     * @Rest\View
	 */
    public function postAction(Request $request) {
        return array('result' => 'OK');
    }
}
