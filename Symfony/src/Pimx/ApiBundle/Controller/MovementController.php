<?php

namespace Pimx\ApiBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\ApiDoc;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use FOS\RestBundle\Routing\ClassResourceInterface;

use Pimx\ModelBundle\Entity\Label;
use Pimx\ModelBundle\Entity\Movement;
use Pimx\ModelBundle\Pagination\Paginator;

/**
 * @RouteResource("Movement", pluralize=false)
 */
class MovementController extends FOSRestController implements ClassResourceInterface  {

    /**
     * @Rest\View
     */
    public function cgetAction() {
        $pageSize = $this->container->getParameter('grid_page_size');
        $currentPage = 1; //$request->get('page', 1);
        $paginator = new Paginator($pageSize, $currentPage);
		
        $filters = array();
		
        $movements = $this->getDoctrine()
                ->getRepository('PimxModelBundle:Movement')
                ->findByFilters($paginator, $filters)
        ;

        return $movements;
    }

    /**
     * @Rest\View
     */
    public function getAction($id) {
        $movement = $this->getDoctrine()
                ->getRepository('PimxModelBundle:Movement')
                ->find($id)
        ;

        if (!($movement instanceof Movement)) {
            throw new NotFoundHttpException('Movement not found');
        }

        return $movement;
    }

    /**
     * @Rest\View
     */
    public function postAction(Request $request) {
        return array('result' => 'OK');
    }
}
