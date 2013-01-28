<?php

namespace Desarrolla2\Bundle\BlogBundle\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

/**
 * Twitter controller.
 *
 * @Route("/twitter")
 */
class TwitterController extends Controller
{

    /**
     * @Route("/", name="_twitter_default")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $twitterClient = $this->container->get('twitter_client');
        return array(
            'twits' => $twitterClient->fetch(30)
        );
    }

}
