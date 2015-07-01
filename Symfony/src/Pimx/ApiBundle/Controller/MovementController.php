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
use Pimx\ModelBundle\Entity\Movement;

class MovementController extends FOSRestController {

    /**
     * @Rest\View
     */
    public function getLatestAction() {
        $pageSize = $this->container->getParameter('list_page_size');

        $movements = $this->getDoctrine()
                ->getRepository('PimxModelBundle:Movement')
                ->findLatest($pageSize)
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

}
