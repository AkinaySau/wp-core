<?php


namespace Sau\WP\Core\Command;


use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Filesystem\Filesystem;

class CacheClearCommand extends Command
{
    /**
     * @var ContainerInterface
     */
    private $container;
    /**
     * @var string
     */
    protected static $defaultName = 'cache:clear';

    public function __construct(ContainerInterface $container)
    {
        parent::__construct(static::$defaultName);
        $this->container = $container;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        try {
            $path = $this->container->getParameter('path.cache');
            $fs   = new Filesystem();
            $fs->remove($path.'/'); //may be need rm only inner files?
            $io->success('Cache clear success');
        } catch (Exception $exception) {
            $io->error($exception->getMessage());
        }

        return 0;
    }
}
