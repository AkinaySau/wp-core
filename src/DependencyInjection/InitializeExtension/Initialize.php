<?php


namespace Sau\WP\Core\DependencyInjection\InitializeExtension;


use Symfony\Component\DependencyInjection\ContainerInterface;

class Initialize
{
    /**
     * @var boolean
     */
    private $is_init = false;
    /**
     * @var array
     */
    private $configs;
    /**
     * @var array
     */
    private $tags;
    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(array $configs)
    {
        $this->configs = $configs;
    }

    public function init(ContainerInterface $container)
    {
        $this->container = $container;
        $this->initConfigs();
        $this->initTags();


        $this->is_init = true;
    }

    /**
     * @return bool
     */
    public function isInit(): bool
    {
        return $this->is_init;
    }

    public function serviceForInit(array $services)
    {
        $this->tags = $services;

        return $this;
    }

    private function initConfigs()
    {
        $for_init = $this->configs[ 'auto_init' ];
        foreach ($for_init as $value) {
            if (is_string($value) && $this->container->has($value)) {
                $this->container->get($value);
            }
        }
    }

    private function initTags()
    {
        $for_init = $this->tags;
        foreach ($for_init as $value) {
            if (is_string($value) && $this->container->has($value)) {
                $this->container->get($value);
            }
        }
    }
}
