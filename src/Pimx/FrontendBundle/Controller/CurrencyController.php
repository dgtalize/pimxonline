<?php

namespace Pimx\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CurrencyController extends Controller {

    public function indexAction(Request $request) {
        $currencies = $this->getDoctrine()
                ->getRepository('PimxModelBundle:Currency')
                ->findAll();

        return $this->render('PimxFrontendBundle:Currency:index.html.twig', array('items' => $currencies));
    }

}
