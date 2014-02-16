<?php

namespace Pimx\FrontendBundle\EventListener;

use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\Bundle\DoctrineBundle\ConnectionFactory;

class SecurityListener {

    /* @var Doctrine\Bundle\DoctrineBundle\Registry */
    private $doctrineRegistry;
    /* @var Symfony\Component\Security\Core\SecurityContext */
    private $securityContext;
    /* @var Symfony\Component\HttpFoundation\Request */
    private $request;
    private $container;

    public function __construct(SecurityContext $securityContext, Registry $doctrineRegistry, ContainerInterface $container) {
        $this->securityContext = $securityContext;
        $this->doctrineRegistry = $doctrineRegistry;
        $this->container = $container;
    }

    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event) {        
        $user = $this->securityContext->getToken()->getUser();
        $this->container->get('doctrine.dbal.default_connection')->forceSwitch(
                $user->getDbname(), //$this->request->get('db_name'),
                $user->getDbuser(),
                $user->getDbpass());
    }

    public function setRequest(Request $request = null)
    {
        $this->request = $request;
    }
}
