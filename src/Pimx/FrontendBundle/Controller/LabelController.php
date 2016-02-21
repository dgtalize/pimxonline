<?php

namespace Pimx\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class LabelController extends Controller {

    public function indexAction() {
        $label = $this->getDoctrine()
                ->getRepository('PimxModelBundle:Label')
                ->findBy(array('parent' => null));

        return $this->render('PimxFrontendBundle:Label:index.html.twig', array('items' => $label));
    }

    public function newAction(Request $request) {
        $label = new \Pimx\ModelBundle\Entity\Label();

        $form = $this->createForm(new \Pimx\FrontendBundle\Form\Type\LabelType(), $label);
        $form->handleRequest($request);

        //Validate before save
        if ($form->isValid()) {
            //save the object
            $em = $this->getDoctrine()->getManager();
            $em->persist($label);
            $em->flush();

            return $this->redirect($this->generateUrl('_label'));
        }

        return $this->render('PimxFrontendBundle:Label:new.html.twig', array(
                    'form' => $form->createView(),
        ));
    }

    public function editAction(Request $request) {
        $item_id = $request->get('item_id');
        $label = $this->getDoctrine()
                ->getRepository('PimxModelBundle:Label')
                ->find($item_id);

        $form = $this->createForm(new \Pimx\FrontendBundle\Form\Type\AccountType(), $label);

        $form->handleRequest($request);
        //Validate before save
        if ($form->isValid()) {
            //save the object
            $em = $this->getDoctrine()->getManager();
            $em->persist($label);
            $em->flush();

            return $this->redirect($this->generateUrl('_label'));
        }

        return $this->render('PimxFrontendBundle:Label:edit.html.twig', array(
                    'form' => $form->createView(),
        ));
    }

}
