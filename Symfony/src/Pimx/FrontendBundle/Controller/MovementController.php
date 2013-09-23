<?php

namespace Pimx\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MovementController extends Controller {

    public function indexAction() {
        $movements = $this->getDoctrine()
                ->getRepository('PimxModelBundle:Movement')
                ->findBy(array(), array('date' => 'DESC'));

        return $this->render('PimxFrontendBundle:Movement:index.html.twig', array('items' => $movements));
    }
    
    public function newAction(Request $request) {

        $movement = new \Pimx\ModelBundle\Entity\Movement();
        $movement->setDate(new \DateTime());

        $form = $this->createForm(new \Pimx\FrontendBundle\Form\Type\MovementType(), $movement);
        $form->handleRequest($request);

        //Validate before save
        if ($form->isValid()) {
            //save the object
            $em = $this->getDoctrine()->getManager();
            $em->persist($movement);
            $em->flush();

            return $this->redirect($this->generateUrl('_movement'));
        }

        return $this->render('PimxFrontendBundle:Movement:new.html.twig', array(
                    'form' => $form->createView(),
        ));
    }
    
    public function editAction(Request $request) {
        $item_id = $request->get('item_id');
        
        $movement = $this->getDoctrine()
                ->getRepository('PimxModelBundle:Movement')
                ->find($item_id);

        $form = $this->createForm(new \Pimx\FrontendBundle\Form\Type\MovementType(), $movement);

        $form->handleRequest($request);

        //Validate before save
        if ($form->isValid()) {
            //save the object
            $em = $this->getDoctrine()->getManager();
            $em->persist($movement);
            $em->flush();

            return $this->redirect($this->generateUrl('_movement'));
        }

        return $this->render('PimxFrontendBundle:Movement:edit.html.twig', array(
            'form' => $form->createView(),
        ));
    }

}
