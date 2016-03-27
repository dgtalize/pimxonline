<?php

namespace Pimx\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Pimx\DoctrineBundle\Connection\ConnectionWrapper;

class DatabaseController extends Controller {

    public function backupAction(Request $request) {
        /* @var $session Symfony\Component\HttpFoundation\Session\Session */
        $session = $this->get('session');
        $dbParams = $session->get(ConnectionWrapper::SESSION_ACTIVE_DYNAMIC_CONN);
        $user = $dbParams['user'];
        $password = $dbParams['password'];
        $database = $dbParams['dbname'];
        
        $backupFile = $this->get('kernel')->getRootdir().'/../public_html/db/backup.sql.gz';
        
        $command = "mysqldump -u $user -p'$password' $database | gzip > $backupFile";

        $result = system($command);
        
        $response = new Response();
        $response->setContent($result);
        
        return $response;
    }

}
