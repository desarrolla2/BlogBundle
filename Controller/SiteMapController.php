<?php
/**
 * This file is part of the desarrolla2/blog-bundle project.
 *
 * Copyright (c)
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
 * Class SiteMapController
 *
 * @author Daniel González <daniel@desarrolla2.com>
 */

class SiteMapController extends Controller
{
    /**
     * @Route("/sitemap.xml", name="_blog_sitemap")
     * @Method({"GET"})
     */
    public function indexAction(Request $request)
    {
        $request->setRequestFormat('xml');

        return $this->render(
            'BlogBundle:/SiteMap:index.xml.twig',
            array()
        );
    }

    /**
     * @Route("/sitemap.archive.xml", name="_blog_sitemap_archive")
     * @Method({"GET"})
     */
    public function archiveAction(Request $request)
    {
        return $this->render(
            'BlogBundle:/SiteMap:archive.xml.twig',
            array(
                'items' => $this->getDoctrine()->getManager()
                        ->getRepository('BlogBundle:Post')->getArchiveItems(),
            )
        );
    }

    /**
     * @Route("/sitemap.post.xml", name="_blog_sitemap_post")
     * @Method({"GET"})
     */
    public function postAction(Request $request)
    {
        $request->setRequestFormat('xml');
        $items = array();
        $posts = $this->getDoctrine()->getManager()
            ->getRepository('BlogBundle:Post')->get(
                $this->container->getParameter('blog.sitemap.items')
            );
        foreach ($posts as $post) {
            $items[] = $this->generateUrl('_blog_view', array('slug' => $post->getSlug()), true);
        }

        return $this->render(
            'BlogBundle:/SiteMap:post.xml.twig',
            array(
                'items' => $items,
            )
        );
    }

    /**
     * @Route("/sitemap.search.xml", name="_blog_sitemap_search")
     * @Method({"GET"})
     */
    public function searchAction(Request $request)
    {

        $items = array();

        return $this->render(
            'BlogBundle:/SiteMap:archive.xml.twig',
            array(
                'items' => $items,
            )
        );
    }

    /**
     * @Route("/sitemap.tag.xml", name="_blog_sitemap_tag")
     * @Method({"GET"})
     */
    public function tagAction(Request $request)
    {
        $request->setRequestFormat('xml');
        $items = array();
        $tags = $this->getDoctrine()->getManager()
            ->getRepository('BlogBundle:Tag')->get(
                $this->container->getParameter('blog.sitemap.items')
            );
        foreach ($tags as $tag) {
            $items[] = $this->generateUrl('_blog_tag', array('slug' => $tag->getSlug()), true);
        }

        return $this->render(
            'BlogBundle:/SiteMap:tag.xml.twig',
            array(
                'items' => $items,
            )
        );
    }
}
