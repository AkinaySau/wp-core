<?php

namespace Sau\WP\Core\DependencyInjection;

use Sau\WP\Core\Carbon\Carbon;
use Sau\WP\Core\Carbon\Container;
use Sau\WP\Core\Carbon\GutenbergBlock;
use Sau\WP\Core\DependencyInjection\Configuration\CarbonConfiguration;
use Sau\WP\Core\Twig\TwigEngine;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Extension\Extension;

class CarbonExtension extends Extension implements CompilerPassInterface
{

    /**
     * You can modify the container here before it is dumped to PHP code.
     */
    public function process(ContainerBuilder $container)
    {
        $definition = $container->getDefinition('carbon');

        $definition->addMethodCall(
            'registerContainers',
            [$container->findTaggedServiceIds('twig.extension')]
        );
        $definition->addMethodCall(
            'registerBlock',
            [$container->findTaggedServiceIds('twig.extension')]
        );

    }

    /**
     * Loads a specific configuration.
     *
     * @throws \InvalidArgumentException When provided tag is not defined in this extension
     */
    public function load(array $configs, ContainerBuilder $container)
    {

        $configuration = new CarbonConfiguration();
        $configs       = $this->processConfiguration($configuration, $configs);

        /* todo add widget
        $container->registerForAutoconfiguration(BaseWidget::class)
                  ->addTag('carbon.widget');
        */
        $container->registerForAutoconfiguration(Container::class)
                  ->addTag('carbon.container');
        $container->registerForAutoconfiguration(GutenbergBlock::class)
                  ->addTag('carbon.block');

        $definition = new Definition(Carbon::class);
        $definition->setPublic(true);
        $container->setDefinition('carbon', $definition);

    }

    /**
     * Returns the namespace to be used for this extension (XML namespace).
     *
     * @return string The XML namespace
     */
    public function getNamespace()
    {
        return 'http://www.example.com/symfony/schema/';
    }

    /**
     * Returns the base path for the XSD files.
     *
     * @return string The XSD base path
     */
    public function getXsdValidationBasePath()
    {
        return false;
    }

    /**
     * Returns the recommended alias to use in XML.
     *
     * This alias is also the mandatory prefix to use when using YAML.
     *
     * @return string The alias
     */
    public function getAlias()
    {
        return 'carbon';
    }
}
