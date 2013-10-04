<?php

namespace Desarrolla2\Bundle\BlogBundle\Controller\Backend;

use \Symfony\Bundle\FrameworkBundle\Controller\Controller;
use \Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use \Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use \Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use \Desarrolla2\Bundle\BlogBundle\Entity\Image;
use \Desarrolla2\Bundle\BlogBundle\Form\Backend\Type\ImageType;
use \Desarrolla2\Bundle\BlogBundle\Form\Backend\Type\ImageFilterType;
use \Desarrolla2\Bundle\BlogBundle\Form\Backend\Model\ImageModel;
use \Desarrolla2\Bundle\BlogBundle\Form\Backend\Model\ImageFilterModel;
use \Desarrolla2\Bundle\BlogBundle\Form\Backend\Handler\ImageHandler;
use \Desarrolla2\Bundle\BlogBundle\Form\Backend\Handler\ImageFilterHandler;

/**
 * Image controller.
 *
 * @Route("/image")
 */
class ImageController extends Controller
{
    /**
     * Lists all Image entities.
     *
     * @Route("/", name="_blog_backend_image")
     * @Template()
     */
    public function indexAction()
    {
        $paginator = $this->get('knp_paginator');
        $request = $this->getRequest();
        $session = $request->getSession();
        $qb = $this->getDoctrine()->getManager()
            ->getRepository('BlogBundle:Image')->getQueryBuilderForFilter();
        $query = $qb->getQuery();
        $filterForm = $this->createForm(new ImageFilterType(), new ImageFilterModel($request));
        $formHandler = new ImageFilterHandler($filterForm, $request, $qb);

        if ($request->getMethod() == 'POST' && $request->get('filter_action') == 'reset') {
            $session->remove('ImageControllerFilter');
        }

        if ($request->getMethod() == 'POST' && $request->get('filter_action') == 'filter') {
            if ($formHandler->process()) {
                $query = $formHandler->getQuery();
                $session->set('ImageControllerFilter', $request);
            }
        }

        if ($request->getMethod() == 'GET') {
            if ($session->has('ImageControllerFilter')) {
                $filterForm = $this->createForm(
                    new ImageFilterType(),
                    new ImageFilterModel($session->get('ImageControllerFilter'))
                );
                $formHandler = new ImageFilterHandler($filterForm, $session->get('ImageControllerFilter'), $qb);
                if ($formHandler->process()) {
                    $query = $formHandler->getQuery();
                }
            }
        }
        $filterForm = $formHandler->getFilter();

        $pagination = $paginator->paginate(
            $query,
            $request->get('page', 1),
            12
        );

        return array(
            'upload_url' => $this->container->getParameter('blog.upload_url'),
            'pagination' => $pagination,
            'filterForm' => $filterForm->createView(),
        );
    }

    /**
     * Displays a form to create a new Image entity.
     *
     * @Route("/new", name="_blog_backend_image_new")
     * @Template()
     */
    public function newAction()
    {
        $form = $this->createForm(new ImageType(), new ImageModel(new Image()));

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a new Image entity.
     *
     * @Route("/create", name="_blog_backend_image_create")
     * @Method("POST")
     * @Template("BlogBundle:Backend/Image:new.html.twig")
     */
    public function createAction()
    {
        $request = $this->getRequest();
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(new ImageType(), new ImageModel(new Image()));

        $path = $this->container->getParameter('blog.upload_dir');
        if (!file_exists($path)) {
            @mkdir($path, 0777, true);
        }
        $path = realpath($path);
        $formHandler = new ImageHandler($form, $request, new Image(), $em, $path);
        if ($formHandler->process()) {
            return $this->redirect($this->generateUrl('_blog_backend_image'));
        }

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * Deletes a Image entity.
     *
     * @Route("/{id}/delete", name="_blog_backend_image_delete")
     * @Method("POST")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->submit($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BlogBundle:Image')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Image entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('_blog_backend_image'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm();
    }
}
