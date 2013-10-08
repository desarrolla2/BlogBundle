<?php

namespace Desarrolla2\Bundle\BlogBundle\Controller\Backend;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Desarrolla2\Bundle\BlogBundle\Entity\Author;
use Desarrolla2\Bundle\BlogBundle\Form\Backend\Type\AuthorType;
use Desarrolla2\Bundle\BlogBundle\Form\Backend\Type\AuthorFilterType;
use Desarrolla2\Bundle\BlogBundle\Form\Backend\Model\AuthorModel;
use Desarrolla2\Bundle\BlogBundle\Form\Backend\Model\AuthorFilterModel;
use Desarrolla2\Bundle\BlogBundle\Form\Backend\Handler\AuthorHandler;
use Desarrolla2\Bundle\BlogBundle\Form\Backend\Handler\AuthorFilterHandler;

/**
 * Author controller.
 *
 * @Route("/author")
 */
class AuthorController extends Controller
{

    /**
     * Lists all Author entities.
     *
     * @Route("/", name="_blog_backend_author")
     * @Template()
     */
    public function indexAction()
    {
        $paginator = $this->get('knp_paginator');
        $request = $this->getRequest();
        $session = $request->getSession();
        $qb = $this->getDoctrine()->getManager()
            ->getRepository('BlogBundle:Author')->createQueryBuilder('a');
        $query = $qb->getQuery();
        $filterForm = $this->createForm(new AuthorFilterType(), new AuthorFilterModel($request));
        $formHandler = new AuthorFilterHandler($filterForm, $request, $qb);

        if ($request->getMethod() == 'POST' && $request->get('filter_action') == 'reset') {
            $session->remove('AuthorControllerFilter');
        }

        if ($request->getMethod() == 'POST' && $request->get('filter_action') == 'filter') {
            if ($formHandler->process()) {
                $query = $formHandler->getQuery();
                $session->set('AuthorControllerFilter', $request);
            }
        }

        if ($request->getMethod() == 'GET') {
            if ($session->has('AuthorControllerFilter')) {
                $filterForm = $this->createForm(new AuthorFilterType(), new AuthorFilterModel($session->get('AuthorControllerFilter')));
                $formHandler = new AuthorFilterHandler($filterForm, $session->get('AuthorControllerFilter'), $qb);
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
     * Displays a form to create a new Author entity.
     *
     * @Route("/new", name="_blog_backend_author_new")
     * @Template()
     */
    public function newAction()
    {
        $form = $this->createForm(new AuthorType(), new AuthorModel(new Author()));

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a new Author entity.
     *
     * @Route("/create", name="_blog_backend_author_create")
     * @Method("POST")
     * @Template("BlogBundle:Backend/Author:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $request = $this->getRequest();
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(new AuthorType(), new AuthorModel(new Author()));
        $formHandler = new AuthorHandler($form, $request, new Author(), $em);
        if ($formHandler->process()) {
            return $this->redirect($this->generateUrl('_blog_backend_author'));
        }

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Author entity.
     *
     * @Route("/{id}/edit", name="author_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('BlogBundle:Author')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Author entity.');
        }
        $form = $this->createForm(new AuthorType(), new AuthorModel($entity));
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'form'        => $form->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Author entity.
     *
     * @Route("/{id}/update", name="_blog_backend_author_update")
     * @Method("POST")
     * @Template("BlogBundle:Backend/Author:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $request = $this->getRequest();
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('BlogBundle:Author')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Author entity.');
        }
        $editForm = $this->createForm(new AuthorType(), new AuthorModel($entity));
        $deleteForm = $this->createDeleteForm($id);
        $formHandler = new AuthorHandler($editForm, $request, $entity, $em);
        if ($formHandler->process()) {
            return $this->redirect($this->generateUrl('_blog_backend_author'));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Author entity.
     *
     * @Route("/{id}/delete", name="_blog_backend_author_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->submit($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BlogBundle:Author')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Author entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('_blog_backend_author'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
            ;
    }

}
