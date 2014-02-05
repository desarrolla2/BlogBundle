<?php

/*
 * This file is part of the desarrolla2 package.
 *
 * Short description
 *
 * @author Daniel González <daniel@desarrolla2.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Desarrolla2\Bundle\BlogBundle\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Desarrolla2\Bundle\BlogBundle\Entity\Post;

class WidgetController extends Controller
{

    /**
     * @Template()
     */
    public function latestCommentAction()
    {
        return array(
            'comments' =>
                $this->getDoctrine()->getManager()
                    ->getRepository('BlogBundle:Comment')->getLatest(4)
        );
    }

    /**
     * @Template()
     */
    public function latestCommentRelatedAction(Post $post, $items = 3)
    {
        return array(
            'comments' =>
                $this->getDoctrine()->getManager()
                    ->getRepository('BlogBundle:Comment')->getLatestRelated($post, $items)
        );
    }

    /**
     * @Template()
     */
    public function latestPostAction()
    {
        return array(
            'posts' =>
                $this->getDoctrine()->getManager()
                    ->getRepository('BlogBundle:Post')->getLatest(4)
        );
    }

    /**
     * @Template()
     */
    public function latestPostRelatedAction(Post $post)
    {
        return array(
            'posts' =>
                $this->getDoctrine()->getManager()
                    ->getRepository('BlogBundle:Post')->getLatestRelated($post, 4)
        );
    }

    /**
     * @Template()
     */
    public function tagsAction()
    {
        return array(
            'tags' =>
                $this->getDoctrine()->getManager()
                    ->getRepository('BlogBundle:Tag')->get()
        );
    }

    /**
     * @Template()
     */
    public function linksAction()
    {
        return array(
            'links' =>
                $this->getDoctrine()->getManager()
                    ->getRepository('BlogBundle:Link')->getActiveOrdered()
        );
    }

    /**
     * @Template()
     */
    public function postViewRelatedAction($post, $items = 3)
    {
        $search = $this->get('blog.search');

        return array(
            'related' => $search->related($post, $items),
        );
    }

    /**
     * @Template()
     */
    public function bannerAction()
    {
        return array(
            'banner' => $this->getDoctrine()->getManager()
                    ->getRepository('BlogBundle:Banner')->getRandomActive()
        );

    }

    /**
     * @Template()
     */
    public function mostAction()
    {
        return array();
    }
}
