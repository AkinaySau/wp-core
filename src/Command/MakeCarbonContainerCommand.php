<?php


namespace Sau\WP\Core\Command;

use Sau\WP\Core\Command\Make\CarbonContainerMake;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\StyleInterface;

class MakeCarbonContainerCommand extends AbstractMakeCommand
{
    protected static $defaultName = 'make:carbon:container';

    protected function configure()
    {
        $this->setDescription('Generate new carbon container');
    }

    protected function make(InputInterface $input, OutputInterface $output, StyleInterface $style)
    {
        $containerBuilder = new CarbonContainerMake($style, $this->getConfigs());
        $containerBuilder->save();
    }
}
