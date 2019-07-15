<?php

namespace Sau\WP\Core\DependencyInjection;

use Sau\WP\Core\DependencyInjection\Configuration\InitializeConfiguration;
use Sau\WP\Core\DependencyInjection\InitializeExtension\Initialize;
use Sau\WP\Core\DependencyInjection\InitializeExtension\InitializeInterface;
use Sau\WP\Core\DependencyInjection\InitializeExtension\InitializePass;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Extension\Extension;

class InitializeExtension extends Extension implements CompilerPassInterface
{

    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        $definition = $container->getDefinition('initialize');

        $definition->addMethodCall('serviceForInit', [$container->findTaggedServiceIds('initialize.auto')]);
    }

    /**
     * Loads a specific configuration.
     *
     * @param array            $configs
     * @param ContainerBuilder $container
     *
     * @throws \Exception
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new InitializeConfiguration();
        $configs       = $this->processConfiguration($configuration, $configs);

        $container->registerForAutoconfiguration(InitializeInterface::class)
                  ->addTag('initialize.auto');

        $definition = new Definition(Initialize::class, [$configs]);
        $definition->setPublic(true);
        $container->setDefinition('initialize', $definition);


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
        return 'initialize';
    }
}
