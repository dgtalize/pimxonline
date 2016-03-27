<?php

namespace Pimx\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Pimx\DoctrineBundle\Connection\ConnectionWrapper;

class DatabaseController extends Controller {

    public function backupAction(Request $request) {
        $logger = $this->get('logger');

        /* @var $session Symfony\Component\HttpFoundation\Session\Session */
        $session = $this->get('session');
        $dbParams = $session->get(ConnectionWrapper::SESSION_ACTIVE_DYNAMIC_CONN);
        $user = $dbParams['dbuser'];
        $password = $dbParams['dbpass'];
        $database = $dbParams['dbname'];

        $backupDirPath = $this->get('kernel')->getRootdir() . '/../db/';
        $backupFileName = $database . " " . date('Y-m-d') . ".sql";
        $backupFilePath = $backupDirPath . $backupFileName;

        $command = "mysqldump -u $user -p'$password' $database --complete-insert --result-file=\"$backupFilePath\"";
//        $command = "mysqldump -u $user -p'$password' $database";
        $logger->info("Database backup: $command");

        try {
            $result = system($command);
            
            $response = new BinaryFileResponse($backupFilePath);
            $response->headers->set('Content-Type', 'text/plain');
            $response->setContentDisposition(
                    ResponseHeaderBag::DISPOSITION_ATTACHMENT, $backupFileName
            );

            return $response;
        } catch (\Exception $ex) {
            $logger->info("Database backup error: " . $ex->getMessage());
            $translator = $this->get('translator');
            $this->addFlash('danger', $translator->trans('database.backup_error'));

            return $this->render('PimxFrontendBundle:Database:backup.html.twig', array());
        }
    }

}
