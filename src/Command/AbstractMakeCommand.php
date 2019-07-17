<?php


namespace Sau\WP\Core\Command;


use Exception;
use Sau\WP\Core\Console\Console;
use Sau\WP\Core\DependencyInjection\Collector\ConsoleCollector;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Exception\ParameterNotFoundException;
use Symfony\Component\Filesystem\Filesystem;

abstract class AbstractMakeCommand extends Command
{
    /**
     * @var ContainerInterface
     */
    private $container;
    /**
     * Path to plugin/theme
     * @var string
     */
    private $base_path;
    /**
     * @var array
     */
    private $configs;

    public function __construct(ContainerInterface $container, Console $console)
    {
        parent::__construct(self::getDefaultName());
        $this->container = $container;
        $this->configs   = $console->getCollector()
                                   ->getConfigs()[ 'make' ];
        if ( ! $this->container->hasParameter('path.base')) {
            throw new ParameterNotFoundException('path.base');
        }
        $this->base_path = $this->container->getParameter('path.base');
    }

    protected function configure()
    {

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        try {
            $this->make($input, $output, $io);
        } catch (Exception $exception) {
            $io->error($exception->getMessage());
        }

    }

    abstract protected function make(InputInterface $input, OutputInterface $output, SymfonyStyle $io);

    /**
     * @return ContainerInterface
     */
    public function getContainer(): ContainerInterface
    {
        return $this->container;
    }

    /**
     * @return string
     */
    public function getBasePath(): string
    {
        return $this->base_path;
    }

    /**
     * @return array
     */
    public function getConfigs(): array
    {
        return $this->configs;
    }

}
