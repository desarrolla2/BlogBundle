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

use Desarrolla2\Bundle\BlogBundle\Entity\Post;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * WidgetController
 */
class WidgetController extends Controller
{
    /**
     * @Template()
     */
    public function latestCommentAction()
    {
        return [
            'comments' => $this->getDoctrine()->getManager()
                    ->getRepository('BlogBundle:Comment')->getLatest(4)
        ];
    }

    /**
     * @Template()
     */
    public function latestCommentRelatedAction(Post $post, $items = 3)
    {
        return [
            'comments' => $this->getDoctrine()->getManager()
                    ->getRepository('BlogBundle:Comment')->getLatestRelated($post, $items)
        ];
    }

    /**
     * @Template()
     */
    public function latestPostAction()
    {
        return [
            'posts' => $this->getDoctrine()->getManager()
                    ->getRepository('BlogBundle:Post')->getLatest(4)
        ];
    }

    /**
     * @Template()
     */
    public function latestPostRelatedAction(Post $post)
    {
        return [];

        return [
            'posts' => $this->getDoctrine()->getManager()
                    ->getRepository('BlogBundle:Post')->getLatestRelated($post, 4)
        ];
    }

    /**
     * @Template()
     */
    public function tagsAction()
    {
        return [
            'tags' => $this->getDoctrine()->getManager()
                    ->getRepository('BlogBundle:Tag')->get()
        ];
    }

    /**
     * @Template()
     */
    public function linksAction()
    {
        return [
            'links' => $this->getDoctrine()->getManager()
                    ->getRepository('BlogBundle:Link')->getActiveOrdered()
        ];
    }

    /**
     * @Template()
     */
    public function postViewRelatedAction($post, $items = 3)
    {
        return [
            'related' => []
        ];
        $search = $this->get('blog.search');

        return [
            'related' => $search->related($post, $items),
        ];
    }

    /**
     * @Template()
     */
    public function bannerAction()
    {
        return [
            'banner' => $this->getDoctrine()->getManager()
                ->getRepository('BlogBundle:Banner')->getRandomActive()
        ];
    }

    /**
     * @Template()
     */
    public function mostAction()
    {
        return [];
    }
}
