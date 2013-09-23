<?php

namespace Pimx\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AccountController extends Controller {

    public function indexAction() {
        $accounts = $this->getDoctrine()
                ->getRepository('PimxModelBundle:Account')
                ->findAll();

        return $this->render('PimxFrontendBundle:Account:index.html.twig', array('items' => $accounts));
    }

    public function newAction(Request $request) {

        $account = new \Pimx\ModelBundle\Entity\Account();

        $form = $this->createForm(new \Pimx\FrontendBundle\Form\Type\AccountType(), $account);
        $form->handleRequest($request);

        //Validate before save
        if ($form->isValid()) {
            //save the object
            $em = $this->getDoctrine()->getManager();
            $em->persist($account);
            $em->flush();

            return $this->redirect($this->generateUrl('_account'));
        }

        return $this->render('PimxFrontendBundle:Account:new.html.twig', array(
                    'form' => $form->createView(),
        ));
    }

    public function editAction(Request $request) {
        $item_id = $request->get('item_id');
        $account = $this->getDoctrine()
                ->getRepository('PimxModelBundle:Account')
                ->find($item_id);

        $form = $this->createForm(new \Pimx\FrontendBundle\Form\Type\AccountType(), $account);

        $form->handleRequest($request);
        //Validate before save
        if ($form->isValid()) {
            //save the object
            $em = $this->getDoctrine()->getManager();
            $em->persist($account);
            $em->flush();

            return $this->redirect($this->generateUrl('_account'));
        }

        return $this->render('PimxFrontendBundle:Account:edit.html.twig', array(
                    'form' => $form->createView(),
        ));
    }

}
