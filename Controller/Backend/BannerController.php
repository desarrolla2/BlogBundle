<?php
/**
 * This file is part of the desarrolla2/blog-bundle package.
 *
 * (c) Daniel González <daniel@desarrolla2.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Desarrolla2\Bundle\BlogBundle\Controller\Backend;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Desarrolla2\Bundle\BlogBundle\Form\Backend\Type\BannerFilterType;
use Desarrolla2\Bundle\BlogBundle\Form\Backend\Model\BannerFilterModel;
use Desarrolla2\Bundle\BlogBundle\Form\Backend\Handler\BannerFilterHandler;
use Desarrolla2\Bundle\BlogBundle\Form\Backend\Type\BannerType;
use Desarrolla2\Bundle\BlogBundle\Form\Backend\Model\BannerModel;
use Desarrolla2\Bundle\BlogBundle\Form\Backend\Handler\BannerHandler;
use Desarrolla2\Bundle\BlogBundle\Entity\Banner;

/**
 * BannerController
 *
 * @Route("/banner")
 */
class BannerController extends Controller
{
    /**
     * Lists all Banner entities.
     *
     * @Route("/", name="_blog_backend_banner")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $paginator = $this->get('knp_paginator');
        $session = $request->getSession();
        $qb = $this->getDoctrine()
            ->getManager()
            ->getRepository('BlogBundle:Banner')
            ->getQueryBuilderForFilter();

        $query = $qb->getQuery();
        $filterForm = $this->createForm(new BannerFilterType(), new BannerFilterModel($request));
        $formHandler = new BannerFilterHandler($filterForm, $request, $qb);

        if ($request->getMethod() == 'POST' && $request->get('filter_action') == 'reset') {
            $session->remove('BannerControllerFilter');
        }

        if ($request->getMethod() == 'POST' && $request->get('filter_action') == 'filter') {
            if ($formHandler->process()) {
                $query = $formHandler->getQuery();
                $session->set('BannerControllerFilter', $request);
            }
        }

        if ($request->getMethod() == 'GET') {
            if ($session->has('BannerControllerFilter')) {
                $filterForm = $this->createForm(
                    new BannerFilterType(),
                    new BannerFilterModel($session->get('BannerControllerFilter'))
                );
                $formHandler = new BannerFilterHandler($filterForm, $session->get('PostControllerFilter'), $qb);
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
            'pagination' => $pagination,
            'filterForm' => $filterForm->createView(),
        );

    }

    /**
     * Displays a form to create a new Banner entity.
     *
     * @Route("/new", name="_blog_backend_banner_new")
     * @Template()
     */
    public function newAction()
    {
        $form = $this->createForm(new BannerType(), new BannerModel(new Banner()));

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a new Banner entity.
     *
     * @Route("/create", name="_blog_backend_banner_create")
     * @Method("POST")
     * @Template("BlogBundle:Backend/Banner:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(new BannerType(), new BannerModel(new Banner()));
        $formHandler = new BannerHandler($form, $request, $em);
        if ($formHandler->process(new Banner())) {
            return $this->redirect($this->generateUrl('_blog_backend_banner'));
        }

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * Edits an existing Author entity.
     *
     * @Route("/{id}/update", name="_blog_backend_banner_update")
     * @Method("POST")
     * @Template("BlogBundle:Backend/Banner:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('BlogBundle:Banner')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Banner entity.');
        }
        $editForm = $this->createForm(new BannerType(), new BannerModel($entity));
        $deleteForm = $this->createDeleteForm($id);
        $formHandler = new BannerHandler($editForm, $request, $em);
        if ($formHandler->process($entity)) {
            return $this->redirect($this->generateUrl('_blog_backend_banner'));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Banner entity.
     *
     * @Route("/{id}/edit", name="_blog_backend_banner_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('BlogBundle:Banner')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Banner entity.');
        }
        $form = $this->createForm(new BannerType(), new BannerModel($entity));
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Banner entity.
     *
     * @Route("/{id}/delete", name="_blog_backend_banner_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->submit($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BlogBundle:Banner')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Banner entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('_blog_backend_banner'));
    }

    /**
     * Publish a Banner
     *
     * @Route("/{id}/publish", name="_blog_backend_banner_publish")
     */
    public function publishAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('BlogBundle:Banner')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Banner entity.');
        }
        $entity->setIsPublished(true);
        $em->persist($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('_blog_backend_banner'));
    }

    /**
     * Unpublish a Banner
     *
     * @Route("/{id}/unpublish", name="_blog_backend_banner_unpublish")
     */
    public function unPublishAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('BlogBundle:Banner')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Banner entity.');
        }
        $entity->setIsPublished(false);
        $em->persist($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('_blog_backend_banner'));
    }

    /**
     *
     * @Route("/{id}/preview" , name="_blog_backend_banner_preview")
     * @Method({"GET"})
     * @Template()
     */
    public function viewAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('BlogBundle:Banner')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Banner entity.');
        }
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'banner' => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * @param $id
     *
     * @return \Symfony\Component\Form\Form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm();
    }
}