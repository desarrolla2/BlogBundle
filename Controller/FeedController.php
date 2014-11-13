<?php

/**
 * This file is part of the desarrolla2 project.
 *
 * Copyright (c)
 * Daniel González <daniel@desarrolla2.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.
 */

namespace Desarrolla2\Bundle\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;

/**
 *
 * Description of FeedController
 *
 * @author : Daniel González <daniel@desarrolla2.com>
 */
class FeedController extends Controller
{
    /**
     * @Route("/feed/", name="_blog_feed")
     * @Route("/feed.{_format}")
     * @Method({"GET"})
     */
    public function indexAction(Request $request)
    {
        $request->setRequestFormat('xml');
        $items = $this->getDoctrine()->getManager()
            ->getRepository('BlogBundle:Post')->get(
                $this->container->getParameter('blog.rss.items')
            );

        return $this->render(
            'BlogBundle:/Feed:index.xml.twig',
            array(
                'title' => $this->container->getParameter('blog.rss.title'),
                'description' => $this->container->getParameter('blog.rss.description'),
                'language' => $this->container->getParameter('blog.rss.language'),
                'ttl' => $this->container->getParameter('blog.rss.ttl'),
                'items' => $items,
            )
        );
    }

    /**
     * @Route("/feed/{slug}/", name="_blog_feed_tag", requirements={"slug" = "[\w\d\-]+"})
     * @Method({"GET"})
     */
    public function tagAction(Request $request)
    {
        $request->setRequestFormat('xml');
        $tag = $this->getDoctrine()->getManager()
            ->getRepository('BlogBundle:Tag')->getOneBySlug($request->get('slug', false));
        if (!$tag) {
            throw $this->createNotFoundException('The tag does not exist');
        }
        $items = $this->getDoctrine()->getManager()
            ->getRepository('BlogBundle:Post')->getByTag(
                $tag,
                $this->container->getParameter('blog.rss.items')
            );

        return $this->render(
            'BlogBundle:/Feed:index.xml.twig',
            array(
                'title' => $this->container->getParameter('blog.rss.title') . ' :: ' . $tag->getName(),
                'description' => $this->container->getParameter('blog.rss.description'),
                'language' => $this->container->getParameter('blog.rss.language'),
                'ttl' => $this->container->getParameter('blog.rss.ttl'),
                'items' => $items,
            )
        );
    }

}
