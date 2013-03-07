<?php

/**
 * This file is part of the planetubuntu proyect.
 * 
 * Copyright (c)
 * Daniel González Cerviño <daniel.gonzalez@externos.seap.minhap.es>  
 * 
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.
 */

namespace Desarrolla2\Bundle\BlogBundle\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;

/**
 * 
 * Description of SearchController
 *
 */
class SearchController extends Controller {

    /**
     * @Route("/search", name="_search")
     * @Method({"GET"})
     * @Template()
     */
    public function indexAction(Request $request) {
        $query = $request->get('q', '');
        $handler = new \SphinxClient();
        $handler->SetServer("desarrolla2.com", 9312);
        $handler->SetMaxQueryTime(3000);
        $handler->SetMatchMode(SPH_MATCH_ANY);
        $handler->SetSortMode(SPH_SORT_RELEVANCE);
        $handler->SetFieldWeights(array(
            'name' => 5,
            'intro' => 1,
            'content' => 1
        ));
        $result = $handler->Query($query, 'planetubuntu_idx');
        if ($result === false) {
            echo "Query failed: " . $handler->GetLastError() . ".\n";
        } else {
            if ($handler->GetLastWarning()) {
                echo "WARNING: " . $handler->GetLastWarning() . "
";
            }

            if (!empty($result["matches"])) {
                foreach ($result["matches"] as $doc => $docinfo) {
                   ladybug_dump($doc);
                }

            }
        }

        die();


        return array(
            'pagination' => $pagination,
            'title' => $this->container->getParameter('blog.title'),
            'description' => $this->container->getParameter('blog.description'),
        );
    }

}