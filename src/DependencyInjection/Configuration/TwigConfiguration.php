<?php


namespace Sau\WP\Core\DependencyInjection\Configuration;


use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Twig\Template;

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
            ->booleanNode('debug')
                ->defaultValue('%debug%')
            ->end()
            ->scalarNode('charset')
                ->defaultValue('utf-8')
            ->end()
            ->scalarNode('base_template_class')
                ->defaultValue(Template::class)
            ->end()
            //todo need add validate for cache node (false or string)
            ->scalarNode('cache')
                /*
                ->validate()
                    ->ifTrue(function ($var){
                        if ($var!==false || !is_string($var) )
                            return false;
                        return true;
                    })
                ->end()
                */
                ->defaultValue("%path.cache%/twig")
            ->end()
            ->booleanNode('auto_reload')
                ->defaultTrue()
            ->end()
            ->booleanNode('strict_variables')
                ->defaultTrue()
            ->end()
            ->scalarNode('autoescape')
            ->end()
            ->integerNode('optimizations')
                ->defaultValue(-1)
            ->end()
            ->arrayNode('environments')
                ->scalarPrototype()->end()
            ->end()
        ->end();

        return $treeBuilder;
    }
}
