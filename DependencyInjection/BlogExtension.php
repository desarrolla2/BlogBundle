<?php

namespace Desarrolla2\Bundle\BlogBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class BlogExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        foreach ($config as $key => $value) {
            $this->parseNode($container, 'blog.' . $key, $value);
        }

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('twig.xml');
        $loader->load('sanitizer.xml');
        $loader->load('search.xml');
        $loader->load('post.xml');

        $container->setParameter('blog', $config);
    }

    protected function parseNode($container, $name, $value)
    {
        if (is_string($value)) {
            $container->setParameter($name, $value);

            return;
        }
        if (is_integer($value)) {
            $container->setParameter($name, $value);

            return;
        }
        if (is_array($value)) {
            foreach ($value as $newKey => $newValue) {
                $this->parseNode($container, $name . '.' . $newKey, $newValue);
            }

            return;
        }
        throw new \Exception(gettype($value) . ' not support');
    }

}
