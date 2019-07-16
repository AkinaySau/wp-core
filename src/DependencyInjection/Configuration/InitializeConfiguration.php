<?php


namespace Sau\WP\Core\DependencyInjection\Configuration;


use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class InitializeConfiguration implements ConfigurationInterface
{

    /**
     * Generates the configuration tree builder.
     *
     * @return TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('initialize');
        $rootNode    = $treeBuilder->getRootNode();

        $rootNode->children()
                 ->arrayNode('auto_init')
                    ->info('List services for auto initialize')
                    ->scalarPrototype()
                 ->end()
                 ->end();

        return $treeBuilder;
    }
}
