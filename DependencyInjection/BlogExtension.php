<?php

namespace Desarrolla2\Bundle\BlogBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\Definition;

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
        
        $container->setParameter('blog.title', $config['title']);
        $container->setParameter('blog.description', $config['description']);
        $container->setParameter('blog.items', $config['items']);
        
        $container->setParameter('blog.rss.name', $config['rss']['name']);
        $container->setParameter('blog.rss.items', $config['rss']['items']);
        
        $container->setParameter('blog.sitemap.items', $config['sitemap']['items']);
        
        $container->setParameter('blog.archive.title', $config['archive']['title']);
        $container->setParameter('blog.archive.description', $config['archive']['description']);
        
        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.xml');

    }

}
