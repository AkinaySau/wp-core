<?php


namespace Sau\WP\Core\Command;

use Sau\WP\Core\Command\Make\CarbonContainerMake;
use Sau\WP\Core\Command\Make\RESTMake;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\StyleInterface;

class MakeRESTControllerCommand extends AbstractMakeCommand
{
    protected static $defaultName = 'make:rest';

    protected function configure()
    {
        $this->addArgument('controller_name',InputArgument::OPTIONAL,'Name for REST controller')
             ->setDescription('Generate new carbon container');
    }

    protected function make(InputInterface $input, OutputInterface $output, StyleInterface $style)
    {
        $restBuilder = new RESTMake($style, $this->getConfigs());
        $restBuilder->save();
    }
}
