<?php


namespace Sau\WP\Core\DependencyInjection\Configuration;


use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class WPConfiguration implements ConfigurationInterface
{

    /**
     * Generates the configuration tree builder.
     *
     * @return TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('wp');
        $rootNode    = $treeBuilder->getRootNode();

        $rootNode->children()
                 ->end();

        $this->registerMenuConfig($rootNode);

        return $treeBuilder;
    }

    private function registerMenuConfig(ArrayNodeDefinition $rootNode)
    {
        $rootNode->children()
                     ->arrayNode('menu')
                         ->scalarPrototype()
                     ->end()
                 ->end()
        ;
    }
}
