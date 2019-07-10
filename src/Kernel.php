<?php

namespace Sau\WP\Core;

use Symfony\Component\Config\ConfigCache;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Dumper\PhpDumper;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class Kernel
{
    private $base_path;
    /**
     * @var void
     */
    private $container;
    private $debug;

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

    private function initContainer()
    {
        $file                 = $this->getCachePath().'/container.php';
        $containerConfigCache = new ConfigCache($file, $this->isDebug());

        if ( ! $containerConfigCache->isFresh()) {


            $containerBuilder = new ContainerBuilder();
            //register default path
            $this->registerDefaultPaths($containerBuilder);

            $this->registerCoreExtensions($containerBuilder);

            //$this->registerConfiguration($containerBuilder);

            //load services
            $this->loadServicesConfig($containerBuilder);

            //        foreach ($containerBuilder->findTaggedServiceIds('compiler.pass') as $pass) {
            //            $containerBuilder->addCompilerPass($pass);
            //        }


            $containerBuilder->compile();

            $dumper = new PhpDumper($containerBuilder);
            $containerConfigCache->write(
                $dumper->dump(['class' => 'SauWPCoreCachedContainer']),
                $containerBuilder->getResources()
            );
        }

        require_once $file;
        $container = new \SauWPCoreCachedContainer();

        return $container;
        //        $containerBuilder->registerExtension(new TwigExtension());
    }

    public function run()
    {
//        $this->container;
        dump(
            $this->container->getParameterBag(),
            $this->container->getServiceIds(),
//            $this->container->getExtensions(),
//            $this->container->getDefinitions()
        );
        die();

    }


    private function registerConfiguration(ContainerBuilder $containerBuilder)
    {
        $configDirectories = [dirname(__DIR__).'/configs', $this->getConfigPath()];

        dump($configDirectories);
        die();
    }

    private function loadServicesConfig(ContainerBuilder $containerBuilder)
    {
        $loader = new YamlFileLoader(
            $containerBuilder, new FileLocator($this->getCoreConfigPath())
        );
        $loader->load('services.yaml');
        /*
         * $loader = new YamlFileLoader(
         *      $containerBuilder, new FileLocator($this->getConfigPath())
         * );
         *    $loader->load('services.yaml');
         */
    }

    private function registerDefaultPaths(ContainerBuilder $containerBuilder)
    {
        $containerBuilder->setParameter('path.core', $this->getCorePath());
        $containerBuilder->setParameter('path.core.config', $this->getCoreConfigPath());

        $containerBuilder->setParameter('path.base', $this->getBasePath());
        $containerBuilder->setParameter('path.base.config', $this->getConfigPath());
        $containerBuilder->setParameter('path.base.var', $this->getVarPath());
        $containerBuilder->setParameter('path.base.cache', $this->getCachePath());
        $containerBuilder->setParameter('path.base.views', $this->getViewsPath());
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
}
