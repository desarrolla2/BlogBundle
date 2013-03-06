<?php

namespace Desarrolla2\Bundle\BlogBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $treeBuilder->root('blog')
                ->addDefaultsIfNotSet()
                ->children()
                    ->scalarNode('title')->defaultValue('my blog title')->end()
                    ->scalarNode('description')->defaultValue('my blog description')->end()
                    ->scalarNode('items')->defaultValue(12)->end()             
                
                    ->arrayNode('rss')
                        ->addDefaultsIfNotSet()
                        ->children()
                            ->scalarNode('title')->defaultValue('my RSS Nane')->end()
                            ->scalarNode('items')->defaultValue(16)->end()             
                        ->end()
                    ->end()
                
                    ->arrayNode('sitemap')
                        ->addDefaultsIfNotSet()
                        ->children()
                            ->scalarNode('items')->defaultValue(50)->end()             
                        ->end()
                    ->end()
                
                    ->arrayNode('archive')
                        ->addDefaultsIfNotSet()
                        ->children()
                            ->scalarNode('title')->defaultValue('Blog Archive')->end()
                            ->scalarNode('description')->defaultValue('my archive description')->end()             
                        ->end()
                    ->end()
                ->end();

        return $treeBuilder;
    }
    
}
