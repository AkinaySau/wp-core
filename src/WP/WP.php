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
        $this->registerRest();
    }

    private function registerActions()
    {
        foreach ($this->collector->getActions() as $id => $params) {
            $this->container->get($id)
                            ->action();
        }
    }


    private function registerRest()
    {
        add_action(
            'rest_api_init',
            function () {
                foreach ($this->collector->getRest() as $id => $item) {
                    $this->container->get($id)
                                    ->register_routes();
                }
            }
        );
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
