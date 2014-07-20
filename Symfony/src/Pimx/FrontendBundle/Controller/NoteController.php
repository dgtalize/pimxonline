<?php

namespace Pimx\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class NoteController extends Controller {

    public function indexAction() {
        $notes = $this->getDoctrine()
                ->getRepository('PimxModelBundle:Note')
                ->findAll();

        return $this->render('PimxFrontendBundle:Note:index.html.twig', array('items' => $notes));
    }

    public function newAction(Request $request) {

        $note = new \Pimx\ModelBundle\Entity\Note();

        $form = $this->createForm(new \Pimx\FrontendBundle\Form\Type\NoteType(), $note);
        $form->handleRequest($request);

        //Validate before save
        if ($form->isValid()) {
            //save the object
            $em = $this->getDoctrine()->getManager();
            $em->persist($note);
            $em->flush();

            $translator = $this->get('translator');
            $this->get('session')->getFlashBag()->add(
                    'success',
                    $translator->trans('text.elementsaved', array('%element%' => $translator->trans('text.note')))
            );
            return $this->redirect($this->generateUrl('_note'));
        }

        return $this->render('PimxFrontendBundle:Note:new.html.twig', array(
                    'form' => $form->createView(),
        ));
    }

    public function editAction(Request $request) {
        $item_id = $request->get('item_id');
        $note = $this->getDoctrine()
                ->getRepository('PimxModelBundle:Note')
                ->find($item_id);

        $note->setCryptPassword("123456");
        
        $form = $this->createForm(new \Pimx\FrontendBundle\Form\Type\NoteType(), $note);

        $form->handleRequest($request);
        //Validate before save
        if ($form->isValid()) {
            //save the object
            $em = $this->getDoctrine()->getManager();
            $em->persist($note);
            $em->flush();

            $translator = $this->get('translator');
            $this->get('session')->getFlashBag()->add(
                    'success',
                    $translator->trans('text.elementsaved', array('%element%' => $translator->trans('text.note')))
            );
            return $this->redirect($this->generateUrl('_note'));
        }

        return $this->render('PimxFrontendBundle:Note:edit.html.twig', array(
                    'form' => $form->createView(),
        ));
    }

}
