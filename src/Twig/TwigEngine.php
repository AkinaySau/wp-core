<?php


namespace Sau\WP\Core\Twig;


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

    public function __construct(array $configs)
    {
        $this->configs = $configs;
    }

    public function registerExtensions()
    {
        if ($this->isRegisteredExtensions) {
            return;
        }
        foreach ($this->extensions as $class => $extension) {
            $this->environment->addExtension(new $class);
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
}
