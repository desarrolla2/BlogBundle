<?php

/*
 * This file is part of the BlogBundle package.
 *
 * Copyright (c) daniel@desarrolla2.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Daniel González <daniel@desarrolla2.com>
 */

namespace Desarrolla2\Bundle\BlogBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class BlogExtension extends Extension
{
    /**
     * @var ContainerBuilder
     */
    protected $container;

    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $this->container = $container;

        $files = [
            'twig',
            'search',
            'manager',
            'imagine',
        ];

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        foreach ($config as $key => $value) {
            $this->parseNode('blog.'.$key, $value);
        }

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        foreach ($files as $file) {
            $loader->load($file.'.xml');
        }

        $container->setParameter('blog', $config);
    }

    /**
     * @param string $name
     * @param mixed  $value
     *
     * @throws \Exception
     */
    protected function parseNode($name, $value)
    {
        if (is_string($value)) {
            $this->set($name, $value);

            return;
        }
        if (is_integer($value)) {
            $this->set($name, $value);

            return;
        }
        if (is_array($value)) {
            foreach ($value as $newKey => $newValue) {
                $this->parseNode($name.'.'.$newKey, $newValue);
            }

            return;
        }
        throw new \Exception(gettype($value).' not supported');
    }

    /**
     * @param string $key
     * @param mixed  $value
     */
    protected function set($key, $value)
    {
        $this->container->setParameter($key, $value);
    }
}
