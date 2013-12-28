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

        $rootNode->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('title')->defaultValue('my blog title')->end()
            ->scalarNode('description')->defaultValue('my blog description')->end()
            ->scalarNode('items')->defaultValue(12)->end()
            ->scalarNode('ga_tracking')->defaultValue('')->end()
            ->scalarNode('locale')->defaultValue('en')->end()
            ->scalarNode('upload_dir')->defaultValue('%kernel.root_dir%/../web/uploads')->end()
            ->scalarNode('upload_url')->defaultValue('/uploads')->end()
            ->append($this->createSearchSection())
            ->append($this->createSiteMapSection())
            ->append($this->createRSSSection())
            ->end();

        return $treeBuilder;
    }

    private function createSearchSection()
    {
        $builder = new TreeBuilder();
        $node = $builder->root('search');
        $node
            ->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('provider')->defaultValue('mysql')->end()
            ->arrayNode('mysql')
            ->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('connection')->defaultValue('')->end()
            ->scalarNode('manager')->defaultValue('')->end()
            ->end()
            ->end()
            ->arrayNode('sphinx')
            ->addDefaultsIfNotSet()
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
        $node->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('items')->defaultValue(2000)->end()
            ->end();

        return $node;
    }

    private function createRSSSection()
    {
        $builder = new TreeBuilder();
        $node = $builder->root('rss');
        $node->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('title')->defaultValue('RSS Feed')->end()
            ->scalarNode('description')->defaultValue('my RSS feed')->end()
            ->scalarNode('language')->defaultValue('en')->end()
            ->scalarNode('items')->defaultValue(16)->end()
            ->scalarNode('ttl')->defaultValue(60)->end()
            ->end();

        return $node;
    }

}
