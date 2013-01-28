<?php

namespace Desarrolla2\Bundle\BlogBundle\Controller\Backend;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Desarrolla2\Bundle\BlogBundle\Entity\Comment;
use Desarrolla2\Bundle\BlogBundle\Form\Backend\Type\CommentType;
use Desarrolla2\Bundle\BlogBundle\Form\Backend\Type\CommentFilterType;
use Desarrolla2\Bundle\BlogBundle\Form\Backend\Model\CommentModel;
use Desarrolla2\Bundle\BlogBundle\Form\Backend\Model\CommentFilterModel;
use \Desarrolla2\Bundle\BlogBundle\Form\Backend\Handler\CommentHandler;
use Desarrolla2\Bundle\BlogBundle\Form\Backend\Handler\CommentFilterHandler;

/**
 * Comment controller.
 *
 * @Route("/comment")
 */
class CommentController extends Controller
{

    /**
     * Lists all Comment entities.
     *
     * @Route("/", name="comment")
     * @Template()
     */
    public function indexAction()
    {
        $paginator = $this->get('knp_paginator');
        $request = $this->getRequest();
        $session = $request->getSession();
        $qb = $this->getDoctrine()->getEntityManager()
                        ->getRepository('BlogBundle:Comment')->getQueryBuilderForFilter();
        $query = $qb->getQuery();
        $filterForm = $this->createForm(new CommentFilterType(), new CommentFilterModel($request));
        $formHandler = new CommentFilterHandler($filterForm, $request, $qb);

        if ($request->getMethod() == 'POST' && $request->get('filter_action') == 'reset') {
            $session->remove('CommentControllerFilter');
        }

        if ($request->getMethod() == 'POST' && $request->get('filter_action') == 'filter') {
            if ($formHandler->process()) {
                $query = $formHandler->getQuery();
                $session->set('CommentControllerFilter', $request);
            }
        }

        if ($request->getMethod() == 'GET') {
            if ($session->has('CommentControllerFilter')) {
                $filterForm = $this->createForm(new CommentFilterType(), new CommentFilterModel($session->get('CommentControllerFilter')));
                $formHandler = new CommentFilterHandler($filterForm, $session->get('CommentControllerFilter'), $qb);
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
     * Creates a new Comment entity.
     *
     * @Route("/create", name="comment_create")
     * @Method("POST")
     * @Template("BlogBundle:Backend/Comment:new.html.twig")
     */
    public function createAction()
    {
        $request = $this->getRequest();
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(new CommentType(), new CommentModel(new Comment()));
        $formHandler = new CommentHandler($form, $request, new Comment(), $em);
        if ($formHandler->process()) {
            return $this->redirect($this->generateUrl('comment'));
        }

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Comment entity.
     *
     * @Route("/{id}/edit", name="comment_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('BlogBundle:Comment')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Comment entity.');
        }
        $form = $this->createForm(new CommentType(), new CommentModel($entity));
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'form'        => $form->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Comment entity.
     *
     * @Route("/{id}/update", name="comment_update")
     * @Method("POST")
     * @Template("BlogBundle:Backend/Comment:edit.html.twig")
     */
    public function updateAction($id)
    {
        $request = $this->getRequest();
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('BlogBundle:Comment')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Comment entity.');
        }
        $form = $this->createForm(new CommentType(), new CommentModel($entity));
        $deleteForm = $this->createDeleteForm($id);
        $formHandler = new CommentHandler($form, $request, $entity, $em);
        if ($formHandler->process()) {
            return $this->redirect($this->generateUrl('comment'));
        }

        return array(
            'entity'      => $entity,
            'form'        => $form->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Comment entity.
     *
     * @Route("/{id}/delete", name="comment_delete")
     * @Method("POST")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->getRepository('BlogBundle:Comment')->delete($id);           
        }

        return $this->redirect($this->generateUrl('comment'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
                        ->add('id', 'hidden')
                        ->getForm()
        ;
    }

    /**
     * Publish a Comment
     *
     * @Route("/{id}/publish", name="comment_publish")
     */
    public function publishAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('BlogBundle:Comment')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Comment entity.');
        }
        $entity->setStatus(1);
        $em->persist($entity);
        $em->flush();
        return $this->redirect($this->generateUrl('comment'));
    }

    /**
     * Unpublish a Comment
     *
     * @Route("/{id}/unpublish", name="comment_unpublish")
     */
    public function unPublishAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('BlogBundle:Comment')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Comment entity.');
        }
        $entity->setStatus(2);
        $em->persist($entity);
        $em->flush();
        return $this->redirect($this->generateUrl('comment'));
    }

}
