<?php

namespace Desarrolla2\Bundle\BlogBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

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
        $rootNode = $treeBuilder->root('blog');
        $rootNode
            ->children()
            ->scalarNode('title')->defaultValue('my blog title')->end()
            ->scalarNode('description')->defaultValue('my blog description')->end()
            ->scalarNode('items')->defaultValue(12)->end()
            ->append($this->createSearchSection())
            ->append($this->createSiteMapSection())
            ->append($this->createRSSSection())
            ->append($this->createArchiveSection())
            ->end();

        return $treeBuilder;
    }

    private function createSearchSection()
    {
        $builder = new TreeBuilder();
        $node = $builder->root('search');
        $node
            ->children()
            ->arrayNode('sphinx')
            ->children()
            ->scalarNode('host')->defaultValue('localhost')->end()
            ->scalarNode('port')->defaultValue(9312)->end()
            ->scalarNode('index')->defaultValue('search_idx')->end()
            ->scalarNode('items')->defaultValue(12)->end()
            ->end()
            ->end()
            ->end();

        return $node;
    }

    private function createSiteMapSection()
    {
        $builder = new TreeBuilder();
        $node = $builder->root('sitemap');
        $node
            ->children()
            ->scalarNode('items')->defaultValue(50)->end()
            ->end();

        return $node;
    }

    private function createRSSSection()
    {
        $builder = new TreeBuilder();
        $node = $builder->root('rss');
        $node
            ->children()
            ->scalarNode('title')->defaultValue('RSS Feed')->end()
            ->scalarNode('description')->defaultValue('')->end()
            ->scalarNode('language')->defaultValue('en')->end()
            ->scalarNode('items')->defaultValue(16)->end()
            ->scalarNode('ttl')->defaultValue(60)->end()
            ->end();

        return $node;
    }

    private function createArchiveSection()
    {
        $builder = new TreeBuilder();
        $node = $builder->root('archive');
        $node
            ->children()
            ->scalarNode('title')->defaultValue('Blog Archive')->end()
            ->scalarNode('description')->defaultValue('my archive description')->end()
            ->end();

        return $node;
    }
}
