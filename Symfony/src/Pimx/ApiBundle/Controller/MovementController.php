<?php

namespace Pimx\ApiBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Controller\Annotations\ApiDoc;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

use Pimx\ModelBundle\Entity\Label;
use Pimx\ModelBundle\Entity\Movement;
use Pimx\ModelBundle\Pagination\Paginator;

class MovementController extends FOSRestController {

    /**
     * @Rest\View
     * @Rest\Get("/latest")
     */
    public function getLatestAction(Request $request) {
        $pageSize = $this->container->getParameter('grid_page_size');
        $currentPage = $request->get('page', 1);
        $paginator = new Paginator($pageSize, $currentPage);
		
        $filters = array();
		
        $movements = $this->getDoctrine()
                ->getRepository('PimxModelBundle:Movement')
                ->findByFilters($paginator, $filters)
        ;

        return array('movements' => $movements);
    }

    /**
     * @Rest\View
     * @Rest\Get("/{id}", requirements={"id" = "\d+"})
     */
    public function getMovementAction($id) {
        $movement = $this->getDoctrine()
                ->getRepository('PimxModelBundle:Movement')
                ->find($id)
        ;

        if (!($movement instanceof Movement)) {
            throw new NotFoundHttpException('Movement not found');
        }

        return array('movement' => $movement);
    }

    /**
     * POST Route annotation.
     * @Post("/")
     * @Rest\View
     */
    public function postMovementAction(Request $request) {
        return array('result' => 'OK');
    }

    
    /**
     * @Rest\View
     * @Rest\Get("/type")
     */
    public function getTypesAction() {

        $types = $this->getDoctrine()
                ->getRepository('PimxModelBundle:MovementType')
                ->findAll()
        ;

        return array('types' => $types);
    }
    
    /**
     * @Rest\View
     * @Rest\Get("/group")
     */
    public function getGroupsAction() {

        $groups = $this->getDoctrine()
                ->getRepository('PimxModelBundle:MovementGroup')
                ->findAll()
        ;

        return array('groups' => $groups);
    }
}
