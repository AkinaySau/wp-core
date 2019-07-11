<?php


namespace Sau\WP\Core\DependencyInjection\Configuration;


use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class TwigConfiguration implements ConfigurationInterface
{

    /**
     * Generates the configuration tree builder.
     *
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('twig');
        $rootNode    = $treeBuilder->getRootNode();

        $rootNode->children()
                     ->booleanNode('auto_connect')
                     ->defaultTrue()
                 ->end()
                 ->scalarNode('default_connection')
                     ->defaultValue('default')
                    ->end()
                 ->end();

        return $treeBuilder;
    }
}
