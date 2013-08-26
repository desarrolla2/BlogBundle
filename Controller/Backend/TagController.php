<?php

namespace Desarrolla2\Bundle\BlogBundle\Controller\Backend;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Desarrolla2\Bundle\BlogBundle\Entity\Tag;
use Desarrolla2\Bundle\BlogBundle\Form\Backend\Type\TagType;
use Desarrolla2\Bundle\BlogBundle\Form\Backend\Type\TagFilterType;
use Desarrolla2\Bundle\BlogBundle\Form\Backend\Model\TagModel;
use Desarrolla2\Bundle\BlogBundle\Form\Backend\Model\TagFilterModel;
use \Desarrolla2\Bundle\BlogBundle\Form\Backend\Handler\TagHandler;
use Desarrolla2\Bundle\BlogBundle\Form\Backend\Handler\TagFilterHandler;

/**
 * Tag controller.
 *
 * @Route("/tag")
 */
class TagController extends Controller
{

    /**
     * Lists all Tag entities.
     *
     * @Route("/", name="tag")
     * @Template()
     */
    public function indexAction()
    {
        $paginator = $this->get('knp_paginator');
        $request = $this->getRequest();
        $session = $request->getSession();
        $qb = $this->getDoctrine()->getManager()
                        ->getRepository('BlogBundle:Tag')->getQueryBuilderForFilter();
        $query = $qb->getQuery();
        $filterForm = $this->createForm(new TagFilterType(), new TagFilterModel($request));
        $formHandler = new TagFilterHandler($filterForm, $request, $qb);

        if ($request->getMethod() == 'POST' && $request->get('filter_action') == 'reset') {
            $session->remove('TagControllerFilter');
        }

        if ($request->getMethod() == 'POST' && $request->get('filter_action') == 'filter') {
            if ($formHandler->process()) {
                $query = $formHandler->getQuery();
                $session->set('TagControllerFilter', $request);
            }
        }

        if ($request->getMethod() == 'GET') {
            if ($session->has('TagControllerFilter')) {
                $filterForm = $this->createForm(new TagFilterType(), new TagFilterModel($session->get('TagControllerFilter')));
                $formHandler = new TagFilterHandler($filterForm, $session->get('TagControllerFilter'), $qb);
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
     * Displays a form to create a new Tag entity.
     *
     * @Route("/new", name="tag_new")
     * @Template()
     */
    public function newAction()
    {
        $form = $this->createForm(new TagType(), new TagModel(new Tag()));

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a new Tag entity.
     *
     * @Route("/create", name="tag_create")
     * @Method("POST")
     * @Template("BlogBundle:Backend/Tag:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $request = $this->getRequest();
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(new TagType(), new TagModel(new Tag()));
        $formHandler = new TagHandler($form, $request, new Tag(), $em);
        if ($formHandler->process()) {
            return $this->redirect($this->generateUrl('tag'));
        }

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Tag entity.
     *
     * @Route("/{id}/edit", name="tag_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('BlogBundle:Tag')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tag entity.');
        }
        $form = $this->createForm(new TagType(), new TagModel($entity));
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'form'        => $form->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Tag entity.
     *
     * @Route("/{id}/update", name="tag_update")
     * @Method("POST")
     * @Template("BlogBundle:Backend/Tag:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $request = $this->getRequest();
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('BlogBundle:Tag')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tag entity.');
        }
        $form = $this->createForm(new TagType(), new TagModel($entity));
        $deleteForm = $this->createDeleteForm($id);
        $formHandler = new TagHandler($form, $request, $entity, $em);
        if ($formHandler->process()) {
            return $this->redirect($this->generateUrl('tag'));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Tag entity.
     *
     * @Route("/{id}/delete", name="tag_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->submit($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BlogBundle:Tag')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Tag entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('tag'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
                        ->add('id', 'hidden')
                        ->getForm()
        ;
    }

}
