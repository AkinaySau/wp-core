<?php

namespace Sau\WP\Core;

use Symfony\Component\Config\ConfigCache;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Loader\DelegatingLoader;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Config\Loader\LoaderResolver;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Dumper\PhpDumper;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\ClosureLoader;
use Symfony\Component\DependencyInjection\Loader\DirectoryLoader;
use Symfony\Component\DependencyInjection\Loader\GlobFileLoader;
use Symfony\Component\DependencyInjection\Loader\IniFileLoader;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Filesystem\Filesystem;

class Kernel
{
    private $base_path;

    /**
     * @var ContainerInterface
     */
    private $container;
    private $debug;


    const CONFIG_EXTS = '.{yaml,yml}';

    public function __construct(string $theme_dir, $debug = true)
    {
        $this->base_path = $theme_dir;
        $this->debug     = $debug;

        $this->container = $this->initContainer();
    }

    /**
     * Return dir where deploy project
     *
     * @return string
     */
    public function getBasePath(): string
    {
        return $this->base_path;
    }

    public function getConfigPath()
    {
        return $this->getBasePath().'/configs';
    }

    public function getVarPath()
    {
        return $this->getBasePath().'/var';
    }

    public function getCachePath()
    {
        return $this->getVarPath().'/cache';
    }

    private function getLogPath()
    {
        return $this->getVarPath().'/log';
    }

    public function getViewsPath()
    {
        return $this->getBasePath().'/views';
    }

    /**
     * Return library dir
     *
     * @return string
     */
    public function getCorePath()
    {
        return dirname(__DIR__);
    }

    public function getCoreConfigPath()
    {
        return $this->getCorePath().'/configs';
    }

    /**
     * @return bool
     */
    public function isDebug(): bool
    {
        return $this->debug;
    }

    public function getContainerClass()
    {
        return 'SauWPCoreCachedContainer';
    }

    private function initContainer()
    {
        $file         = $this->getCachePath().'/container.php';
        $cache        = new ConfigCache($file, $this->isDebug());

        if ( ! $fresh = $cache->isFresh()) {
            $container = $this->buildContainer();

            $loader = $this->getContainerLoader($container);
            $this->registerConfiguration($container, $loader);

            $this->registerCoreExtensions($container);


            $container->compile();
            $dumper = new PhpDumper($container);
            $cache->write(
                $dumper->dump(['class' => 'SauWPCoreCachedContainer']),
                $container->getResources()
            );
        }

        require_once $file;
        $container = new \SauWPCoreCachedContainer();


        /*
        if ($cache->isFresh()) {
            include $cache->getPath();
        } else {
            $containerBuilder = new ContainerBuilder();

            //register default path
            $this->registerDefaultPaths($containerBuilder);

            //configs
            $loader = $this->getContainerLoader($containerBuilder);
            $this->registerConfiguration($containerBuilder, $loader);

            $this->registerCoreExtensions($containerBuilder);

            //$this->registerConfiguration($containerBuilder);


            $containerBuilder->compile();

            $dumper = new PhpDumper($containerBuilder);
            $cache->write(
                $dumper->dump(['class' => 'SauWPCoreCachedContainer']),
                $containerBuilder->getResources()
            );
        }

        require_once $file;
        $container = new \SauWPCoreCachedContainer();
        */

        return $container;
    }

    protected function buildContainer()
    {
        foreach (['cache' => $this->getCachePath(), 'logs' => $this->getLogPath()] as $name => $dir) {
            if ( ! is_dir($dir)) {
                if (false === @mkdir($dir, 0777, true) && ! is_dir($dir)) {
                    throw new \RuntimeException(sprintf("Unable to create the %s directory (%s)\n", $name, $dir));
                }
            } elseif ( ! is_writable($dir)) {
                throw new \RuntimeException(sprintf("Unable to write in the %s directory (%s)\n", $name, $dir));
            }
        }
        $container = $this->getContainerBuilder();

        return $container;
    }

    protected function getContainerBuilder(): ContainerBuilder
    {
        $container = new ContainerBuilder();
        $container->getParameterBag()
                  ->add($this->getDefaultPaths());

        return $container;
    }


    public function run()
    {

        dump(
            $this->container->getParameterBag(),
            $this->container->getServiceIds(),
            );
        //        die();

    }

    private function registerConfiguration(ContainerBuilder $containerBuilder, LoaderInterface $loader)
    {
        //base services
        $loader->load($this->getCoreConfigPath().'/{packages}/*'.self::CONFIG_EXTS,'glob');
        $loader->load($this->getCoreConfigPath().'/{services}'.self::CONFIG_EXTS,'glob');

        $loader->load($this->getConfigPath().'/{packages}/*'.self::CONFIG_EXTS,'glob');
        $loader->load($this->getConfigPath().'/{services}'.self::CONFIG_EXTS,'glob');

        //$loader->load($this->getConfigPath().'/{packages}/'.$this->environment.'/**/*'.self::CONFIG_EXTS, 'glob');
        //$loader->load($this->getConfigPath().'/{services}_'.$this->environment.self::CONFIG_EXTS, 'glob');
        /*
         * $loader = new YamlFileLoader(
         *      $containerBuilder, new FileLocator($this->getConfigPath())
         * );
         *    $loader->load('services.yaml');
         */
    }

    private function getDefaultPaths()
    {
        return [
            'path.core'        => $this->getCorePath(),
            'path.core.config' => $this->getCoreConfigPath(),
            'path.base'        => $this->getBasePath(),
            'path.config'      => $this->getConfigPath(),
            'path.var'         => $this->getVarPath(),
            'path.cache'       => $this->getCachePath(),
            'path.views'       => $this->getViewsPath(),
        ];
    }

    public function installTemplate()
    {

    }

    private function registerCoreExtensions(ContainerBuilder $containerBuilder)
    {
        $extensions = include_once $this->getCorePath().'/.extensions.php';
        if (is_array($extensions)) {
            foreach ($extensions as $extension) {
                if ($extension instanceof ExtensionInterface) {
                    $containerBuilder->registerExtension($extension);
                    $containerBuilder->loadFromExtension($extension->getAlias());
                }
            }
        }

    }


    /**
     * @return ContainerInterface
     */
    public function getContainer(): ContainerInterface
    {
        return $this->container;
    }


    protected function getContainerLoader(ContainerBuilder $container)
    {
        $locator  = new FileLocator([$this->getCoreConfigPath(), $this->getConfigPath()]);
        $resolver = new LoaderResolver(
            [
                new XmlFileLoader($container, $locator),
                new YamlFileLoader($container, $locator),
                new IniFileLoader($container, $locator),
                new GlobFileLoader($container, $locator),
                new DirectoryLoader($container, $locator),
                new ClosureLoader($container),
            ]
        );

        return new DelegatingLoader($resolver);
    }

}
