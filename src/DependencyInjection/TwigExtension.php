<?php

namespace Sau\WP\Core\DependencyInjection;

use Sau\WP\Core\Twig\TwigEngine;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;

class TwigExtension implements ExtensionInterface, CompilerPassInterface
{

    /**
     * You can modify the container here before it is dumped to PHP code.
     */
    public function process(ContainerBuilder $container)
    {
        // TODO: Add configuration
        $configs = [
            //'debug'               => true,
            //'charset'             => '',
            //'base_template_class' => '',
            'cache'         => $container->getParameter('path.cache').'/twig',
            'auto_reload'   => true,
            //'strict_variables'    => '',
            //'autoescape'          => '',
            'optimizations' => -1,
        ];

        $definition = new Definition(TwigEngine::class, ['%path.views%', $configs]);
        $definition->setPublic(true);

        $definition->addMethodCall(
            'registerExtensions',
            [$container->findTaggedServiceIds('twig.extension')]
        );

        $container->setDefinition('twig', $definition);
    }

    /**
     * Loads a specific configuration.
     *
     * @throws \InvalidArgumentException When provided tag is not defined in this extension
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $container->registerForAutoconfiguration(\Twig\Extension\ExtensionInterface::class)
                  ->addTag('twig.extension');
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
        return 'twig';
    }

}
