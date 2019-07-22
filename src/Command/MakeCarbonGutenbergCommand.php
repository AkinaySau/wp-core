<?php


namespace Sau\WP\Core\Command;

use Sau\WP\Core\Command\Make\GutenbergContainerMake;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\StyleInterface;
use Symfony\Component\Filesystem\Filesystem;

class MakeCarbonGutenbergCommand extends AbstractMakeCommand
{
    protected static $defaultName = 'make:gutenberg';

    protected function configure()
    {
        $this->setDescription('Generate new gutenberg container');
    }

    protected function make(InputInterface $input, OutputInterface $output, StyleInterface $style)
    {
        $containerBuilder = new GutenbergContainerMake($style, $this->getConfigs());
        $containerBuilder->save();
        $fs      = new Filesystem();
        $absPath = $this->getContainer()
                        ->getParameter('path.views').DIRECTORY_SEPARATOR.$containerBuilder->getTemplate();
        if ( ! $fs->exists($absPath)) {
            $fs->appendToFile($absPath, '{# Create AkinaySau(akinaysau@gmail.com) #}');
        }
    }
}
