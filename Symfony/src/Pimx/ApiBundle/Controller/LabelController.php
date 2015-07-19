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

class LabelController extends FOSRestController {

    /**
     * @Rest\View
     * @Rest\Get("/")
     */
    public function getAction() {
        $labels = $this->getDoctrine()
                ->getRepository('PimxModelBundle:Label')
        ;

        return array('labels' => $labels);
    }

    /**
     * @Rest\View
     * @Rest\Get("/{id}", requirements={"id" = "\d+"})
     */
    public function getLabelAction($id) {
        $label = $this->getDoctrine()
                ->getRepository('PimxModelBundle:Label')
                ->find($id)
        ;

        if (!($label instanceof Label)) {
            throw new NotFoundHttpException('Label not found');
        }

        return array('label' => $label);
    }

    /**
     * POST Route annotation.
     * @Post("/")
     * @Rest\View
     */
    public function postLabelAction(Request $request) {
        return array('result' => 'OK');
    }

}
