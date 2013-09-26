<?php
/**
 * This file is part of the planetubuntu project.
 *
 * Copyright (c)
 *
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.
 */

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Client;
use Doctrine\Common\Annotations\AnnotationRegistry;

/**
 * Class AbstractControllerTest
 *
 * @author Daniel González <daniel.gonzalez@freelancemadrid.es>
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
        $vendorDir = __DIR__ . '/../../../vendor';
        $this->client = static::createClient();
        AnnotationRegistry::registerAutoloadNamespaces(
            array(
                'Sensio\\Bundle\\FrameworkExtraBundle' => $vendorDir . '/sensio/framework-extra-bundle/'
            )
        );
    }
}