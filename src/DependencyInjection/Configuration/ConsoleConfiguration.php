<?php


namespace Sau\WP\Core\DependencyInjection\Configuration;


use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class ConsoleConfiguration implements ConfigurationInterface
{

    /**
     * Generates the configuration tree builder.
     *
     * @return TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('console');
        $rootNode    = $treeBuilder->getRootNode();

        $rootNode->children()
                    ->arrayNode('make')
                        ->isRequired()
                        ->children()
                            ->scalarNode('namespace')
                                ->info('Namespace project')
                                ->isRequired()
                            ->end()
                            ->scalarNode('src')
                                ->info('Source directory')
                                ->isRequired()
                            ->end()
                        ->end()
                     ->end()
                 ->end();

        return $treeBuilder;
    }
}
