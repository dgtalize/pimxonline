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
    /* @var Symfony\Component\HttpFoundation\Session\Session */
    private $session;
    /* @var Symfony\Component\HttpFoundation\Request */
    private $request;
    private $container;

    public function __construct(Session $session, Registry $doctrineRegistry, ContainerInterface $container) {
        $this->session = $session;
        $this->doctrineRegistry = $doctrineRegistry;
        $this->container = $container;
    }

    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event) {
        /* @var $connection Doctrine\DBAL\Connection */
//        $connection = $this->doctrineRegistry->getConnection("default");
        $connection = $this->container->get(sprintf('doctrine.dbal.%s_connection', 'default'));
//        $connection = $this->container->get($sDbalSvcName);
        $connection->close();

        $refConn = new \ReflectionObject($connection);
        $refParams = $refConn->getProperty('_params');
        $refParams->setAccessible('public'); //we have to change it for a moment

        $params = $refParams->getValue($connection);
        $params['dbname'] = $this->request->get('db_name');
        $params['user'] = $this->request->get('db_user');
        $params['password'] = $this->request->get('db_pass');
        $refParams->setAccessible('private');
        $refParams->setValue($connection, $params);

        $this->doctrineRegistry->resetManager("default");
    }

    public function setRequest(Request $request = null)
    {
        $this->request = $request;
    }
}
