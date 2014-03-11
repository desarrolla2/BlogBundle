<?php

/**
 * This file is part of the desarrolla2/blog-bundle project.
 *
 * Copyright (c)
 *
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.
 */

//namespace Desarrolla2\Bundle\BlogBundle\Tests\Controller\App;

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;
use Doctrine\Common\Annotations\AnnotationRegistry;

/**
 * Class AppKernel
 *
 * @author Daniel González <daniel@desarrolla2.com>
 */

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Liip\FunctionalTestBundle\LiipFunctionalTestBundle(),
            new Gregwar\CaptchaBundle\GregwarCaptchaBundle(),
            new Knp\Bundle\PaginatorBundle\KnpPaginatorBundle(),
            new Desarrolla2\Bundle\BlogBundle\BlogBundle(),
        );

        return $bundles;
    }

    /**
     * @param LoaderInterface $loader
     */
    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        // We don't need that Environment stuff, just one config
        $loader->load(__DIR__ . '/config/config.yml');

        $vendorDir = realpath(__DIR__ . '/../../../vendor');

        require_once $vendorDir . '/doctrine/orm/lib/Doctrine/ORM/Mapping/Driver/DoctrineAnnotations.php';
        require_once $vendorDir . '/gedmo/doctrine-extensions/lib/Gedmo/Mapping/Annotation/All.php';

        AnnotationRegistry::registerAutoloadNamespaces(
            array(
                'Sensio\\Bundle\\FrameworkExtraBundle' => $vendorDir . '/sensio/framework-bundle-bundle/',
            )
        );
    }
}
