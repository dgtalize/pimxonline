<?php

namespace Pimx\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Pimx\ModelBundle\Pagination\Paginator;
use Pimx\FrontendBundle\Form\Type\MovementFilterType;
use Pimx\ModelBundle\Entity\Movement;

class MovementController extends Controller {

    public function indexAction(Request $request) {
        //Process filters (if any)
        $filters = array();
        $filterForm = $this->createForm(new MovementFilterType());
        $filterForm->handleRequest($request);
        if ($filterForm->isValid()) {
            $filters = $filterForm->getData();
        }

        $pageSize = $this->container->getParameter('grid_page_size');
        $currentPage = $request->get('page', 1);
        $paginator = new Paginator($pageSize, $currentPage);
//        $movements = $this->getDoctrine()
//                ->getRepository('PimxModelBundle:Movement')
//                ->findBy(array(), array('date' => 'DESC'), $paginator->getPageSize(), // limit
//                $paginator->getOffset() // offset
//        );
        $movements = $this->getDoctrine()
                ->getRepository('PimxModelBundle:Movement')
                ->findByFilters($paginator, $filters)
        ;

        return $this->render('PimxFrontendBundle:Movement:index.html.twig', array(
                    'filter_form' => $filterForm->createView(),
                    'items' => $movements,
                    'paginator' => $paginator
        ));
    }

    public function newAction(Request $request) {
        $movement = new \Pimx\ModelBundle\Entity\Movement();
        $movement->setDate(new \DateTime());

        return $this->processSaveForm($request, $movement, 'PimxFrontendBundle:Movement:new.html.twig');
    }

    public function editAction(Request $request) {
        $item_id = $request->get('item_id');

        $movement = $this->getDoctrine()
                ->getRepository('PimxModelBundle:Movement')
                ->find($item_id);

        return $this->processSaveForm($request, $movement, 'PimxFrontendBundle:Movement:edit.html.twig');
    }

    private function processSaveForm(Request $request, Movement $movement, $view) {
        $form = $this->createForm(new \Pimx\FrontendBundle\Form\Type\MovementType(), $movement);
        $form->handleRequest($request);

        //Validate before save
        if ($form->isValid()) {
            //save the object
            $em = $this->getDoctrine()->getManager();
            $em->persist($movement);
            $em->flush();

            $translator = $this->get('translator');
            $this->get('session')->getFlashBag()->add(
                    'notice',
                    $translator->trans('text.elementsaved', array('%element%' => $translator->trans('text.movement')))
            );
            return $this->redirect($this->generateUrl('_movement'));
        }

        return $this->render($view, array(
                    'form' => $form->createView(),
        ));
    }

}
