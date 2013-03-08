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
                ->end();

        $this->addSiteMapSection($rootNode);
        $this->addRSSSection($rootNode);
        $this->addArchiveSection($rootNode);
        $this->addSearchSection($rootNode);
        return $treeBuilder;
    }
    
        private function addSearchSection(ArrayNodeDefinition $node){
        $node
                ->children()
                    ->arrayNode('search')
                        ->addDefaultsIfNotSet()
                        ->children()
                            ->arrayNode('sphinx')
                                ->children()
                                    ->scalarNode('host')->defaultValue('localhost')->end()             
                                    ->scalarNode('port')->defaultValue(9312)->end()
                                    ->scalarNode('index')->defaultValue('planetubuntu_idx')->end()
                                ->end()    
                            ->end()    
                        ->end()
                    ->end()             
                ->end();
    }
    
    private function addSiteMapSection(ArrayNodeDefinition $node){
        $node
                ->children()
                    ->arrayNode('sitemap')
                        ->addDefaultsIfNotSet()
                        ->children()
                            ->scalarNode('items')->defaultValue(50)->end()             
                        ->end()
                    ->end()             
                ->end();
    }
    
    private function addRSSSection(ArrayNodeDefinition $node){
        $node
                ->children()
                    ->arrayNode('rss')
                        ->addDefaultsIfNotSet()
                        ->children()
                            ->scalarNode('title')->defaultValue('RSS')->end()
                            ->scalarNode('description')->defaultValue('')->end()
                            ->scalarNode('language')->defaultValue('en')->end()                
                            ->scalarNode('items')->defaultValue(16)->end()             
                            ->scalarNode('ttl')->defaultValue(60)->end()             
                        ->end()
                    ->end()
                ->end();
    }
    
    
    private function addArchiveSection(ArrayNodeDefinition $node){
        $node
                ->children()
                    ->arrayNode('archive')
                        ->addDefaultsIfNotSet()
                        ->children()
                            ->scalarNode('title')->defaultValue('Blog Archive')->end()
                            ->scalarNode('description')->defaultValue('my archive description')->end()             
                        ->end()
                    ->end()
                ->end();
    }
    
}
