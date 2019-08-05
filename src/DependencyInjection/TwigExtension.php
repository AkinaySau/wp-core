<?php

namespace Sau\WP\Core\DependencyInjection;

use Sau\WP\Core\DependencyInjection\Collector\TwigCollector;
use Sau\WP\Core\DependencyInjection\Configuration\TwigConfiguration;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Twig\Extension\ExtensionInterface;

class TwigExtension extends Extension implements CompilerPassInterface
{
    /**
     * @var array
     */
    private $configs;

    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        $extensions = $container->findTaggedServiceIds('twig.extension');
        $definition = new Definition(TwigCollector::class, [$this->configs, $extensions]);
        $container->setDefinition('twig_collector', $definition);
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
        $this->configs = $this->processConfiguration($configuration, $configs);

        $container->registerForAutoconfiguration(ExtensionInterface::class)
                  ->addTag('twig.extension')->setPublic(true);
    }
}
