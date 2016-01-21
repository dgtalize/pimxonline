<?php

namespace Pimx\ApiBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

class SecurityController extends FOSRestController {

    /**
     * POST Route annotation.
     * @Post("/login")
     * @Rest\View
     */
    public function postLoginAction(Request $request) {
        return array('auth' => 'OK');
    }

}
