<?php
/**
 * This file is part of the desarrolla2/blog-bundle project.
 *
 * Copyright (c)
 *
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.
 */

namespace Desarrolla2\Bundle\BlogBundle\Tests\Controller\Frontend;

use Desarrolla2\Bundle\BlogBundle\Tests\Controller\AbstractControllerTest;


/**
 * Class PostControllerTest
 *
 * @author Daniel González <daniel@desarrolla2.com>
 */
class PostControllerTest extends AbstractControllerTest
{
    public function setUp()
    {
        parent::setUp();
        $this->loadFixtures(
            array(
                'Desarrolla2\Bundle\BlogBundle\Tests\DataFixtures\LoadPosts',
            )
        );
    }

    /**
     *
     */
    public function testIndexAction()
    {
        $this->client->request('GET', '/');
        $this->assertTrue($this->client->getResponse()->isSuccessful());
    }
}