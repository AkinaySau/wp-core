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



        $this->registerMenuConfig($rootNode);
        $this->registerTranslationConfig($rootNode);
        $this->registerMedia($rootNode);

        return $treeBuilder;
    }

    private function registerMenuConfig(ArrayNodeDefinition $rootNode)
    {
        $rootNode->children()
                     ->arrayNode('menu')
                        ->info('Register new menu position use "register_nav_menus"')
                        ->scalarPrototype()
                     ->end()
                 ->end()
        ;
    }

    private function registerTranslationConfig(ArrayNodeDefinition $rootNode)
    {
        $rootNode->children()
                     ->arrayNode('translation')
                        ->children()
//                            ->scalarNode('domain')
//                                ->info('Constant for use in translate "__(), _e(), ..."')
//                                ->isRequired()
//                                ->validate()
//                                    ->ifTrue(function ($var){
//                                        return !is_string($var);
//                                    })
//                                    ->thenInvalid('must be string')
//                                ->end()
//                            ->end()
//                            ->scalarNode('path')

                        ->end()
                     ->end()
                 ->end();
    }

    private function registerMedia(ArrayNodeDefinition $rootNode)
    {
        $rootNode->children()
                ->arrayNode('media')
                    ->arrayPrototype()
                        ->children()
                            ->scalarNode('name')
                                ->isRequired()
                            ->end()
                            ->integerNode('width')
                                ->min(1)
                                ->isRequired()
                                ->defaultValue(1)
                            ->end()
                            ->integerNode('height')
                                ->min(1)
                                ->isRequired()
                                ->defaultValue(1)
                            ->end()
                            ->scalarNode('crop')
                                ->defaultValue('asd')
                            ->end()
                            ->scalarNode('media_name')->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }
}
