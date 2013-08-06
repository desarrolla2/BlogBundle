<?php

/**
 * This file is part of the planetubuntu project.
 * 
 * Copyright (c)
 * Daniel González Cerviño <daniel.gonzalez@freelancemadrid.es>  
 * 
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.
 */

namespace Desarrolla2\Bundle\BlogBundle\Controller\Backend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Desarrolla2\Bundle\BlogBundle\Entity\Link;
use Desarrolla2\Bundle\BlogBundle\Form\Backend\Type\LinkFilterType;
use Desarrolla2\Bundle\BlogBundle\Form\Backend\Type\LinkType;
use Desarrolla2\Bundle\BlogBundle\Form\Backend\Model\LinkFilterModel;
use Desarrolla2\Bundle\BlogBundle\Form\Backend\Model\LinkModel;
use Desarrolla2\Bundle\BlogBundle\Form\Backend\Handler\LinkFilterHandler;
use Desarrolla2\Bundle\BlogBundle\Form\Backend\Handler\LinkHandler;

/**
 * 
 * Description of LinkController
 *
 */
class LinkController extends Controller {

    /**
     * Lists all Link entities.
     *
     * @Route("/link", name="link")
     * @Template()
     */
    public function indexAction() {
        $paginator = $this->get('knp_paginator');
        $request = $this->getRequest();
        $session = $request->getSession();
        $qb = $this->getDoctrine()->getManager()
                        ->getRepository('BlogBundle:Link')->getQueryBuilderForFilter();
        $query = $qb->getQuery();
        $filterForm = $this->createForm(new LinkFilterType(), new LinkFilterModel($request));
        $formHandler = new LinkFilterHandler($filterForm, $request, $qb);

        if ($request->getMethod() == 'POST' && $request->get('filter_action') == 'reset') {
            $session->remove('LinkControllerFilter');
        }

        if ($request->getMethod() == 'POST' && $request->get('filter_action') == 'filter') {
            if ($formHandler->process()) {
                $query = $formHandler->getQuery();
                $session->set('LinkControllerFilter', $request);
            }
        }

        if ($request->getMethod() == 'GET') {
            if ($session->has('LinkControllerFilter')) {
                $filterForm = $this->createForm(new LinkFilterType(), new LinkFilterModel($session->get('LinkControllerFilter')));
                $formHandler = new LinkFilterHandler($filterForm, $session->get('LinkControllerFilter'), $qb);
                if ($formHandler->process()) {
                    $query = $formHandler->getQuery();
                }
            }
        }
        $filterForm = $formHandler->getFilter();

        $pagination = $paginator->paginate(
                $query, $request->get('page', 1), 12
        );

        return array(
            'pagination' => $pagination,
            'filterForm' => $filterForm->createView(),
        );
    }

    /**
     * Displays a form to create a new Link entity.
     *
     * @Route("/new", name="link_new")
     * @Template()
     */
    public function newAction() {
        $form = $this->createForm(new LinkType(), new LinkModel(new Link()));
        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a new Link entity.
     *
     * @Route("/create", name="link_create")
     * @Method("POST")
     * @Template("BlogBundle:Backend/Link:new.html.twig")
     */
    public function createAction() {
        $request = $this->getRequest();
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(new LinkType(), new LinkModel(new Link()));
        $formHandler = new LinkHandler($form, $request, new Link(), $em);
        if ($formHandler->process()) {
            return $this->redirect($this->generateUrl('link'));
        }

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Link entity.
     *
     * @Route("/{id}/edit", name="link_edit")
     * @Template()
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('BlogBundle:Link')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Link entity.');
        }
        $form = $this->createForm(new LinkType(), new LinkModel($entity));
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Link entity.
     *
     * @Route("/{id}/update", name="link_update")
     * @Method("POST")
     * @Template("BlogBundle:Backend/Link:edit.html.twig")
     */
    public function updateAction($id) {
        $request = $this->getRequest();
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('BlogBundle:Link')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Link entity.');
        }
        $form = $this->createForm(new LinkType(), new LinkModel($entity));
        $deleteForm = $this->createDeleteForm($id);
        $formHandler = new LinkHandler($form, $request, $entity, $em);
        if ($formHandler->process()) {
            return $this->redirect($this->generateUrl('link'));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Link entity.
     *
     * @Route("/{id}/delete", name="link_delete")
     * @Method("POST")
     */
    public function deleteAction($id) {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BlogBundle:Link')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Link entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('link'));
    }

    private function createDeleteForm($id) {
        return $this->createFormBuilder(array('id' => $id))
                        ->add('id', 'hidden')
                        ->getForm()
        ;
    }

    /**
     * Publish a Link
     *
     * @Route("/{id}/publish", name="link_publish")
     */
    public function publishAction($id) {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('BlogBundle:Link')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Link entity.');
        }
        $entity->setIsPublished(true);
        $em->persist($entity);
        $em->flush();
        return $this->redirect($this->generateUrl('link'));
    }

    /**
     * Unpublish a Link
     *
     * @Route("/{id}/unpublish", name="link_unpublish")
     */
    public function unPublishAction($id) {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('BlogBundle:Link')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Link entity.');
        }
        $entity->setIsPublished(false);
        $em->persist($entity);
        $em->flush();
        return $this->redirect($this->generateUrl('link'));
    }

    /**
     * 
     * @Route("/{id}/preview" , name="link_preview")
     * @Method({"GET"})
     * @Template()
     */
    public function viewAction($id) {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('BlogBundle:Link')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Link entity.');
        }
        return array(
            'link' => $entity,
        );
    }

}