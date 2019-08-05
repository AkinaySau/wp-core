<?php


namespace Sau\WP\Core\Twig;


use Sau\WP\Core\DependencyInjection\Collector\TwigCollector;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Loader\FilesystemLoader;

final class TwigEngine
{

    /**
     * @var Environment
     */
    private $environment;

    private $isRegisteredExtensions = false;
    /**
     * @var array
     */
    private $configs;
    /**
     * @var array
     */
    private $extensions;
    /**
     * @var ContainerInterface
     */
    private $container;
    /**
     * @var TwigCollector
     */
    private $collector;

    public function __construct(ContainerInterface $container, TwigCollector $collector)
    {
        $this->container  = $container;
        $this->collector  = $collector;
        $this->configs    = $collector->getConfigs();
        $this->extensions = $collector->getExtensions();
    }

    public function registerExtensions()
    {
        if ($this->isRegisteredExtensions) {
            return;
        }
        if ($this->container) {
            foreach ($this->extensions as $class => $extension) {
                if ($this->container->has($class)) {
                    $this->environment->addExtension($this->container->get($class));
                }
            }
        }
        $this->isRegisteredExtensions = true;
    }

    /**
     * @return bool
     */
    public function isRegisteredExtensions(): bool
    {
        return $this->isRegisteredExtensions;
    }

    /**
     * @return Environment
     * @throws LoaderError
     */
    public function getEnvironment()
    {
        if ( ! $this->environment instanceof Environment) {
            $loader = new FilesystemLoader();
            foreach ($this->configs[ 'environments' ] as $item) {
                $loader->addPath($item[ 'path' ], $item[ 'namespace' ]);
            }
            $this->environment = new Environment(
                $loader, $this->configs
            );
            $this->registerExtensions();
        }

        return $this->environment;
    }

    /**
     * @return array
     */
    public function getConfigs(): array
    {
        return $this->configs;
    }

    /**
     * @param array $extensions
     *
     * @return TwigEngine
     */
    public function setExtensions(array $extensions)
    {
        $this->extensions = $extensions;

        return $this;
    }

    public function setContainer(ContainerInterface $container)
    {
        $this->container = $container;

        return $this;
    }
}
