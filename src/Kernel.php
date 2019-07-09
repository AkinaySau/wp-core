<?php

namespace Sau\WP\Theme;

//use Sau\WP\Theme\DependencyInjection\TwigExtension;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class Kernel
{
    private $base_dir;

    public function __construct(string $theme_dir)
    {
        $this->base_dir = $theme_dir;

        $this->initContainer();
    }

    public function getConfigDir()
    {
        return $this->base_dir.'/configs';
    }

    private function initContainer()
    {
        $containerBuilder = new ContainerBuilder();
        //        dump(dirname(__DIR__).'/configs');
        $loader = new YamlFileLoader($containerBuilder, new FileLocator(dirname(__DIR__).'/configs'));
        $loader->load('services.yaml');

        foreach ($containerBuilder->findTaggedServiceIds('compiler.pass') as $pass) {
            $containerBuilder->addCompilerPass($pass);
        }
        dump($containerBuilder->getDefinitions());

        die();
        //        $containerBuilder->registerExtension(new TwigExtension());
    }
}
