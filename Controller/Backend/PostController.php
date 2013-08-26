<?php

namespace Desarrolla2\Bundle\BlogBundle\Controller\Backend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Desarrolla2\Bundle\BlogBundle\Entity\Post;
use Desarrolla2\Bundle\BlogBundle\Form\Backend\Type\PostType;
use Desarrolla2\Bundle\BlogBundle\Form\Backend\Type\PostFilterType;
use Desarrolla2\Bundle\BlogBundle\Form\Backend\Model\PostModel;
use Desarrolla2\Bundle\BlogBundle\Form\Backend\Model\PostFilterModel;
use \Desarrolla2\Bundle\BlogBundle\Form\Backend\Handler\PostHandler;
use Desarrolla2\Bundle\BlogBundle\Form\Backend\Handler\PostFilterHandler;
use Desarrolla2\Bundle\BlogBundle\Model\PostStatus;

/**
 * Post controller.
 *
 * @Route("/post")
 */
class PostController extends Controller
{

    /**
     * Lists all Post entities.
     *
     * @Route("/", name="post")
     * @Template()
     */
    public function indexAction()
    {
        $paginator = $this->get('knp_paginator');
        $request = $this->getRequest();
        $session = $request->getSession();
        $qb = $this->getDoctrine()->getManager()
                        ->getRepository('BlogBundle:Post')->getQueryBuilderForFilter();
        $query = $qb->getQuery();
        $filterForm = $this->createForm(new PostFilterType(), new PostFilterModel($request));
        $formHandler = new PostFilterHandler($filterForm, $request, $qb);

        if ($request->getMethod() == 'POST' && $request->get('filter_action') == 'reset') {
            $session->remove('PostControllerFilter');
        }

        if ($request->getMethod() == 'POST' && $request->get('filter_action') == 'filter') {
            if ($formHandler->process()) {
                $query = $formHandler->getQuery();
                $session->set('PostControllerFilter', $request);
            }
        }

        if ($request->getMethod() == 'GET') {
            if ($session->has('PostControllerFilter')) {
                $filterForm = $this->createForm(new PostFilterType(), new PostFilterModel($session->get('PostControllerFilter')));
                $formHandler = new PostFilterHandler($filterForm, $session->get('PostControllerFilter'), $qb);
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
     * Displays a form to create a new Post entity.
     *
     * @Route("/new", name="post_new")
     * @Template()
     */
    public function newAction()
    {
        $form = $this->createForm(new PostType(), new PostModel(new Post()));

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a new Post entity.
     *
     * @Route("/create", name="post_create")
     * @Method("POST")
     * @Template("BlogBundle:Backend/Post:new.html.twig")
     */
    public function createAction()
    {
        $request = $this->getRequest();
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(new PostType(), new PostModel(new Post()));
        $formHandler = new PostHandler($form, $request, new Post(), $em);
        if ($formHandler->process()) {
            return $this->redirect($this->generateUrl('post'));
        }

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Post entity.
     *
     * @Route("/{id}/edit", name="post_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('BlogBundle:Post')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Post entity.');
        }
        $form = $this->createForm(new PostType(), new PostModel($entity));
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Post entity.
     *
     * @Route("/{id}/update", name="post_update")
     * @Method("POST")
     * @Template("BlogBundle:Backend/Post:edit.html.twig")
     */
    public function updateAction($id)
    {
        $request = $this->getRequest();
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('BlogBundle:Post')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Post entity.');
        }
        $form = $this->createForm(new PostType(), new PostModel($entity));
        $deleteForm = $this->createDeleteForm($id);
        $formHandler = new PostHandler($form, $request, $entity, $em);
        if ($formHandler->process()) {
            return $this->redirect($this->generateUrl('post'));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Post entity.
     *
     * @Route("/{id}/delete", name="post_delete")
     * @Method("POST")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->submit($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BlogBundle:Post')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Post entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('post'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
                        ->add('id', 'hidden')
                        ->getForm()
        ;
    }

    /**
     * Publish a Post
     *
     * @Route("/{id}/publish", name="post_publish")
     */
    public function publishAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('BlogBundle:Post')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Post entity.');
        }
        $entity->setStatus(PostStatus::PUBLISHED);
        $entity->setPublishedAt(new \DateTime());
        $em->persist($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('post'));
    }

    /**
     * Unpublish a Post
     *
     * @Route("/{id}/unpublish", name="post_unpublish")
     */
    public function unPublishAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('BlogBundle:Post')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Post entity.');
        }
        $entity->setStatus(PostStatus::CREATED);
        $em->persist($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('post'));
    }

    /**
     *
     * @Route("/{id}/preview" , name="post_preview")
     * @Method({"GET"})
     * @Template()
     */
    public function viewAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('BlogBundle:Post')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Post entity.');
        }

        return array(
            'post' => $entity,
        );
    }

}
