<?php

namespace Sau\WP\Core\DependencyInjection;

use Sau\WP\Core\DependencyInjection\Configuration\TwigConfiguration;
use Sau\WP\Core\Twig\Twig;
use Sau\WP\Core\Twig\TwigEngine;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Twig\Extension\ExtensionInterface;

class TwigExtension extends Extension implements CompilerPassInterface
{
    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        $definition = $container->getDefinition('twig_engine');

        $definition->addMethodCall(
            'setExtensions',
            [$container->findTaggedServiceIds('twig.extension')]
        );

    }

    /**
     * Loads a specific configuration.
     *
     * @param array            $configs
     * @param ContainerBuilder $container
     */
    public function load(array $configs, ContainerBuilder $container)
    {

        $configuration = new TwigConfiguration();
        $configs       = $this->processConfiguration($configuration, $configs);

        $container->registerForAutoconfiguration(ExtensionInterface::class)
                  ->addTag('twig.extension');

        $definition = new Definition(TwigEngine::class, [$configs]);
        $container->setDefinition('twig_engine', $definition);

    }
}
