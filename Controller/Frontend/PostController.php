<?php

namespace Desarrolla2\Bundle\BlogBundle\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Desarrolla2\Bundle\BlogBundle\Entity\Post;
use Desarrolla2\Bundle\BlogBundle\Entity\Comment;
use Desarrolla2\Bundle\BlogBundle\Form\Frontend\Type\CommentType;
use Desarrolla2\Bundle\BlogBundle\Form\Frontend\Model\CommentModel;

class PostController extends Controller
{

    /**
     * @Route("/{page}", name="_default", requirements={"page" = "\d{1,3}"}, defaults={"page" = "1" })
     * @Method({"GET"})
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $paginator = $this->get('knp_paginator');
        $query = $this->getDoctrine()->getEntityManager()
                        ->getRepository('BlogBundle:Post')->getQueryForGet();


        $pagination = $paginator->paginate(
                $query, $request->get('page', 1), 12
        );

        return array(
            'pagination'  => $pagination,
            'title'       => $this->container->getParameter('blog.title'),
            'description' => $this->container->getParameter('blog.description'),
        );
    }

    /**
     * @Route("/tag/{slug}/{page}", name="_tag", requirements={"slug" = "[\w\d\-]+", "page" = "\d{1,3}"}, defaults={"page" = "1" })
     * @Method({"GET"})
     * @Template()
     */
    public function tagAction(Request $request)
    {

        $paginator = $this->get('knp_paginator');
        $tag = $request->get('slug', '');
        $query = $this->getDoctrine()->getEntityManager()
                        ->getRepository('BlogBundle:Post')->getQueryForGetByTagSlug($tag);

        $pagination = $paginator->paginate(
                $query, $request->get('page', false), 12
        );

        return array(
            'pagination' => $pagination,
            'title'      => $tag,
        );
    }

    /**
     * 
     * @Route("/post/{slug}" , name="_view", requirements={"slug" = "[\w\d\-]+"})
     * @Method({"GET"})
     * @Template()
     */
    public function viewAction(Request $request)
    {
        $post = $this->getDoctrine()->getEntityManager()
                        ->getRepository('BlogBundle:Post')->getOneBySlug($request->get('slug', false));

        $comments = $this->getDoctrine()->getEntityManager()
                        ->getRepository('BlogBundle:Comment')->getForPost($post);

        $form = $this->createForm(new CommentType(), new CommentModel($this->createCommentForPost($post)));

        return array(
            'post'     => $post,
            'comments' => $comments,
            'form'     => $form->createView(),
        );
    }

    /**
     * 
     * @param \Desarrolla2\Bundle\BlogBundle\Entity\Post $post
     * @return \Desarrolla2\Bundle\BlogBundle\Entity\Comment
     */
    protected function createCommentForPost(Post $post)
    {
        $comment = new Comment();
        $comment->setPost($post);
        return $comment;
    }

}
