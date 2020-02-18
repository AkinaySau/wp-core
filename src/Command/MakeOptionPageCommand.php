<?php


namespace Sau\WP\Core\Command;

use Sau\WP\Core\Command\Make\CarbonContainerMake;
use Sau\WP\Core\Command\Make\OptionsMake;
use Sau\WP\Core\Command\Make\RESTMake;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\StyleInterface;

class MakeOptionPageCommand extends AbstractMakeCommand
{
    protected static $defaultName = 'make:options';

    protected function configure()
    {
        $this->setDescription('Generate new page options');
    }

    protected function make(InputInterface $input, OutputInterface $output, StyleInterface $style)
    {
        $restBuilder = new OptionsMake($style, $this->getConfigs());
        $restBuilder->save();
    }
}
