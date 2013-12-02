<?php
namespace Pimx\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

use Pimx\ModelBundle\Entity\Movement;

class MovementController extends FOSRestController {
    
    public function latestAction() {
        $movements = $this->getDoctrine()
                ->getRepository('PimxModelBundle:Movement')
                ->findLatest(60)
        ;
        
        $view = $this->view($movements, 200)
            ->setTemplate("PimxApiBundle:Movement:getUsers.html.twig")
            ->setTemplateVar('movements')
        ;

        //return array('movements' => $movements);
        return $this->handleView($view);
    }


}
