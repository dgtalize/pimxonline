<?php

namespace Pimx\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Pimx\ModelBundle\Pagination\Paginator;
use Pimx\FrontendBundle\Form\Type\MovementType;
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
        $baseOnId = $request->get("base_on_id");
        /** @var $movement \Pimx\ModelBundle\Entity\Movement */
        $movement = new \Pimx\ModelBundle\Entity\Movement();

        //If it's get, prepare/initialize movement
        if ($request->isMethod(Request::METHOD_GET)) {
            if ($baseOnId) {
                $basedOnMovement = $this->getDoctrine()->getRepository('PimxModelBundle:Movement')->find($baseOnId);
                $movement = clone $basedOnMovement;
                $movement->setId(null);
            }
            $movement->setDate(new \DateTime());
        }

        return $this->processSaveForm($request, $movement, 'PimxFrontendBundle:Movement:edit.html.twig');
    }

    public function editAction(Request $request) {
        $item_id = $request->get('item_id');

        $movement = $this->getDoctrine()
                ->getRepository('PimxModelBundle:Movement')
                ->find($item_id);

        return $this->processSaveForm($request, $movement, 'PimxFrontendBundle:Movement:edit.html.twig');
    }

    public function deleteAction(Request $request) {
        $logger = $this->get('logger');
        $item_id = $request->get('item_id');

        $movement = $this->getDoctrine()
                ->getRepository('PimxModelBundle:Movement')
                ->find($item_id);

        try {
            $em = $this->getDoctrine()->getManager();
            $em->remove($movement);
            $em->flush();

            $translator = $this->get('translator');
            $this->addFlash('success', $translator->trans('text.elementdeleted', array('%element%' => $translator->trans('text.movement')))
            );
        } catch (\Exception $ex) {
            $logger->error('An error ocurred deleting the movement. ' . $ex->getMessage());
            $this->addFlash('danger', 'An error ocurred deleting the movement');
        }

        return $this->redirectToRoute('_movement');
    }

    private function processSaveForm(Request $request, Movement $movement, $view) {
        $form = $this->createForm(new MovementType(), $movement);
        $form->handleRequest($request);

        //Validate before save
        if ($form->isValid()) {
            //save the object
            $em = $this->getDoctrine()->getManager();
            $em->persist($movement);
            $em->flush();

            $translator = $this->get('translator');
            $this->addFlash(
                    'success', $translator->trans('text.elementsaved', array('%element%' => $translator->trans('text.movement')))
            );

            switch ($request->request->get("button_action")) {
                case 'save_and_new':
                    return $this->redirect($this->generateUrl('_movement_new'));
                case 'save_and_new_based':
                    return $this->redirect($this->generateUrl('_movement_new', array('base_on_id' => $movement->getId())));
                default:
                    return $this->redirect($this->generateUrl('_movement'));
            }
        }

        return $this->render($view, array(
                    'form' => $form->createView(),
        ));
    }

}
