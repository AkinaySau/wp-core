<?php

namespace Sau\WP\Core\DependencyInjection;

use Sau\WP\Core\DependencyInjection\Collector\WPCollector;
use Sau\WP\Core\DependencyInjection\Configuration\WPConfiguration;
use Sau\WP\Core\DependencyInjection\WPExtension\ActionInterface;
use Sau\WP\Core\WP\Action\Menu;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Extension\Extension;

class WPExtension extends Extension implements CompilerPassInterface
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
        $actions    = $container->findTaggedServiceIds('wp.actions');
        $definition = new Definition(WPCollector::class, [$this->configs, $actions]);
        $container->setDefinition('wp_collector', $definition);
        $this->menu($container);
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
        $configuration = new WPConfiguration();
        $configs       = $this->processConfiguration($configuration, $configs);
        $this->configs = $configs;


        $container->registerForAutoconfiguration(ActionInterface::class)
                  ->setPublic(true)
                  ->addTag('wp.actions');
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
        return 'wp';
    }

    private function menu(ContainerBuilder $container)
    {
        $container->findDefinition(Menu::class)
                         ->addMethodCall('configure', [$this->configs[ 'menu' ]]);
    }

}
