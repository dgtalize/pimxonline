<?php
namespace Pimx\ApiBundle\Controller;

use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

class MovementController extends FOSRestController {
    
    /**
     * @Rest\View
     */
    public function getLatestAction() {
        $movements = $this->getDoctrine()
                ->getRepository('PimxModelBundle:Movement')
                ->findLatest(60)
        ;
        
//        $view = $this->view($movements, 200)
//            ->setTemplate("PimxApiBundle:Movement:getMovements.html.twig")
//            ->setTemplateVar('movements')
//        ;

        return array('movements' => $movements);
//        return $this->handleView($view);
    }


}
