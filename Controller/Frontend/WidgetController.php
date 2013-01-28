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

class WidgetController extends Controller
{

    /**
     * @Template()
     */
    public function lastTwitAction()
    {
        $twitterClient = $this->container->get('twitter_client');
        return array(
            'twit' => $twitterClient->fetchOne()
        );
    }
    
        /**
     * @Template()
     */
    public function latestCommentAction()
    {
        return array(
            'comments' =>
                    $this->getDoctrine()->getEntityManager()
                    ->getRepository('BlogBundle:Comment')->getLatest(4)
        );
    }

    /**
     * @Template()
     */
    public function latestPostAction()
    {
        return array(
            'posts' =>
                    $this->getDoctrine()->getEntityManager()
                    ->getRepository('BlogBundle:Post')->getLatest(4)
        );
    }

    /**
     * @Template()
     */
    public function tagsAction()
    {
        // order by RAND()
        return array(
            'tags' =>
                    $this->getDoctrine()->getEntityManager()
                    ->getRepository('BlogBundle:Tag')->get()
        );
    }

}
