<?php

/**
 * This file is part of the desarrolla2/blog-bundle project.
 *
 * Copyright (c)
 *
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.
 */

namespace Desarrolla2\Bundle\BlogBundle\Tests\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Client;

/**
 * Class AbstractControllerTest
 *
 * @author Daniel González <daniel@desarrolla2.com>
 */

abstract class AbstractControllerTest extends WebTestCase
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * Setup
     */
    public function setUp()
    {
        $this->client = static::createClient();
        $templatesDir = realpath(__DIR__ . '/../Resources/views/');
        $this->getContainer()->get('twig.loader')->addPath($templatesDir, '__main__');
    }
}
