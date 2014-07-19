<?php

namespace Pimx\ApiBundle\Controller;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

use Pimx\ModelBundle\Entity\Movement;

class MovementController extends FOSRestController {

    /**
     * @Rest\View
     */
    public function getLatestAction() {
        $movements = $this->getDoctrine()
                ->getRepository('PimxModelBundle:Movement')
                ->findLatest(60)
        ;

        return array('movements' => $movements);
    }

    /**
     * @Rest\View
     */
    public function getAction($id) {
        $movement = $this->getDoctrine()
                ->getRepository('PimxModelBundle:Movement')
                ->find($id)
        ;
        
        if (!$movement instanceof Movement) {
            throw new NotFoundHttpException('Movement not found');
        }

        return array('movement' => $movement);
    }

}
