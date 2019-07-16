<?php


namespace Sau\WP\Core\Console;


use Sau\WP\Core\DependencyInjection\Collector\ConsoleCollector;
use Symfony\Component\Console\Application;
use Symfony\Component\DependencyInjection\ContainerInterface;

class Console
{
    /**
     * @var ContainerInterface
     */
    private $container;
    /**
     * @var ConsoleCollector
     */
    private $collector;
    /**
     * @var Application
     */
    private $application;

    public function __construct(ContainerInterface $container, ConsoleCollector $collector)
    {
        $this->container   = $container;
        $this->collector   = $collector;
        $this->application = new Application();

    }

    /**
     * @return ConsoleCollector
     */
    public function getCollector(): ConsoleCollector
    {
        return $this->collector;
    }


    public function run()
    {

    }
}
