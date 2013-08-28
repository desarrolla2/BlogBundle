<?php

/*
 * This file is part of the desarrolla2 package.
 *
 * Short description
 *
 * @author Daniel González <daniel.gonzalez@freelancemadrid.es>
 * @date Aug 9, 2012, 1:40:22 AM
 * @file WidgetsController.php , UTF-8
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
        $related = $search->related($post->getTagsAsString());

        return array(
            'related' => $related,
        );
    }

}
