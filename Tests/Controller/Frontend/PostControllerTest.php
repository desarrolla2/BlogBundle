<?php
/**
 * This file is part of the planetubuntu project.
 *
 * Copyright (c)
 *
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.
 */


/**
 * Class PostControllerTest
 *
 * @author Daniel González <daniel.gonzalez@freelancemadrid.es>
 */
class PostControllerTest extends AbstractControllerTest
{
    /**
     *
     */
    public function testIndexAction()
    {
        $this->client->request('GET', '/');
        var_dump($this->client->getResponse());
        $this->assertTrue($this->client->getResponse()->isSuccessful());
    }
}