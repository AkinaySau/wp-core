<?php


namespace Sau\WP\Core;


use Symfony\Component\Console\Application as BaseApplication;

class Application extends BaseApplication
{
    /**
     * @var Kernel
     */
    private $kernel;
    /**
     * @var object|Console\Console
     */
    private $console;

    public function __construct(Kernel $kernel)
    {
        $this->kernel = $kernel;
        $kernel->run();
        $this->console = $kernel->getContainer()
                                ->get('console');
        parent::__construct('Sau-WPCore', $kernel::VERSION);
        $this->registerCommands();
    }

    /**
     * @return Kernel
     */
    public function getKernel(): Kernel
    {
        return $this->kernel;
    }

    private function registerCommands()
    {
        $container = $this->kernel->getContainer();
        $commands  = [];
        foreach (
            $this->console->getCollector()
                          ->getCommandsIds() as $id
        ) {
            if ($container->has($id)) {
                $commands[] = $container->get($id);
            }
        }

        $this->addCommands($commands);
    }


}
