<?php


namespace Sau\WP\Core\WP;


use Sau\WP\Core\DependencyInjection\Collector\WPCollector;
use Symfony\Component\DependencyInjection\ContainerInterface;

class WP
{
    /**
     * @var WPCollector
     */
    private $collector;
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * Translation domain
     * @var string
     */
    private static $domain;

    public function __construct(ContainerInterface $container, WPCollector $collector)
    {

        $this->collector = $collector;
        $this->container = $container;
        $this->registerActions();
    }

    private function registerActions()
    {
        foreach ($this->collector->getActions() as $id => $params) {
            $this->container->get($id)
                            ->action();
        }
    }

    /**
     * @return string
     */
    public static function getDomain()
    {
        //        return self::$domain;
    }

    public function registerPostTypes()
    {
    }

    public function registerTerms()
    {
    }
}
