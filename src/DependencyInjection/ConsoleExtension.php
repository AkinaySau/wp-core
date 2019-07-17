<?php


namespace Sau\WP\Core\DependencyInjection;


use InvalidArgumentException;
use Sau\WP\Core\DependencyInjection\Collector\ConsoleCollector;
use Sau\WP\Core\DependencyInjection\Configuration\ConsoleConfiguration;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Extension\Extension;

class ConsoleExtension extends Extension implements CompilerPassInterface

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
        $commands   = $container->findTaggedServiceIds('console.command');
        $definition = new Definition(ConsoleCollector::class, [$this->configs, $commands]);
        $definition->setPublic(true);
        $container->setDefinition('console_collector', $definition);
    }

    /**
     * Loads a specific configuration.
     *
     * @param array            $configs
     * @param ContainerBuilder $container
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new ConsoleConfiguration();
        $this->configs = $this->processConfiguration($configuration, $configs);

        $container->registerForAutoconfiguration(Command::class)
                  ->addTag('console.command')
                  ->setPublic(true);

    }
}
