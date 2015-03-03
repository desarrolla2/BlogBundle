<?php

/*
 * This file is part of the BlogBundle package.
 *
 * Copyright (c) daniel@desarrolla2.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Daniel González <daniel@desarrolla2.com>
 */

namespace Desarrolla2\Bundle\BlogBundle\Controller;

use Desarrolla2\Bundle\BlogBundle\Entity\Comment;
use Desarrolla2\Bundle\BlogBundle\Entity\Post;
use Desarrolla2\Bundle\BlogBundle\Form\Model\CommentModel;
use Desarrolla2\Bundle\BlogBundle\Form\Type\CommentType;
use Desarrolla2\Bundle\BlogBundle\Model\PostStatus;
use Doctrine\ORM\Query\QueryException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * PostController
 */
class PostController extends Controller
{
    /**
     * @Route("/{page}", name="_blog_default", requirements={"page" = "\d{1,6}"}, defaults={"page" = "1" })
     * @Method({"GET"})
     * @Template()
     *
     * @param int $page
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @return array
     */
    public function indexAction($page)
    {
        $paginator = $this->get('knp_paginator');
        $query = $this->getDoctrine()->getManager()
            ->getRepository('BlogBundle:Post')->getQueryForGet();

        try {
            $pagination = $paginator->paginate(
                $query,
                $page,
                $this->container->getParameter('blog.items')
            );
        } catch (QueryException $e) {
            throw $this->createNotFoundException('Page not found');
        }

        return [
            'page' => $page,
            'pagination' => $pagination,
            'title' => $this->container->getParameter('blog.title'),
            'description' => $this->container->getParameter('blog.description'),
        ];
    }

    /**
     *
     * @Route("/post/{slug}" , name="_blog_view", requirements={"slug" = "[\w\d\-]+"})
     * @Method({"GET"})
     * @Template()
     *
     * @param Request $request
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function viewAction(Request $request)
    {
        $post = $this->getDoctrine()->getManager()
            ->getRepository('BlogBundle:Post')
            ->getOneBySlug($request->get('slug', false));

        if (!$post) {
            throw $this->createNotFoundException('The post does not exist');
        }
        if ($post->getStatus() != PostStatus::PUBLISHED) {
            return new RedirectResponse($this->generateUrl('_blog_default'), 302);
        }

        $comments = $this->getDoctrine()->getManager()
            ->getRepository('BlogBundle:Comment')->getForPost($post);

        $form = $this->createForm(new CommentType(), new CommentModel($this->createCommentForPost($post)));

        return [
            'post' => $post,
            'comments' => $comments,
            'form' => $form->createView(),
        ];
    }

    /**
     *
     * @Route("/view/post/{slug}" , name="_blog_post_view", requirements={"slug" = "[\w\d\-]+"})
     * @Method({"POST"})
     *
     * @param Request $request
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @return Response
     */
    public function postViewAction(Request $request)
    {
        $post = $this->getDoctrine()->getManager()
            ->getRepository('BlogBundle:Post')->getOneBySlug($request->get('slug', false));
        if (!$post) {
            throw $this->createNotFoundException('The post does not exist');
        }

        $this->getDoctrine()->getManager()
            ->getRepository('BlogBundle:PostView')
            ->add($post);

        return new Response();
    }

    /**
     * @param \Desarrolla2\Bundle\BlogBundle\Entity\Post $post
     *
     * @return \Desarrolla2\Bundle\BlogBundle\Entity\Comment
     */
    protected function createCommentForPost(Post $post)
    {
        $comment = new Comment();
        $comment->setPost($post);

        return $comment;
    }
}
