<?php


namespace Sau\WP\Core\Command;


use ChangeCase\ChangeCase;
use Exception;
use Nette\PhpGenerator\PhpNamespace;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Filesystem\Filesystem;

class CommandMakeCommand extends AbstractMakeCommand
{
    use MakeTrait;
    protected static $defaultName = 'make:command';

    protected function configure()
    {
        $this->setDescription('For generate new commands')
             ->addOption('name', null, InputArgument::REQUIRED, 'Block name', null);
    }

    protected function make(InputInterface $input, OutputInterface $output, SymfonyStyle $io)
    {
        if ( ! $name = $input->getOption('name')) {
            $name = $this->getBlockName($io);
        }
        $namespace = $this->getNamespace();
        $name      = strtolower($name);

        $namespace = new PhpNamespace($namespace);
        //    $this->getConfigs()['namespace'].'\Command\"$namespace"\')
        $namespace->addUse(InputArgument::class);
        $namespace->addUse(InputInterface::class);
        $namespace->addUse(OutputInterface::class);
        $namespace->addUse(SymfonyStyle::class);
        $namespace->addUse(Exception::class);
        $namespace->addUse(Command::class);

        $class = $namespace->addClass($this->getFullClass($name));
        $class->addExtend(Command::class)
              ->addConstant('COMMAND', $name);
        $method = $class->addMethod('__construct');
        $method->setBody('parent::__construct(static::COMMAND);');

        $method = $class->addMethod('configure');
        $method->setBody('//todo: configure your command');

        $method = $class->addMethod('execute');
        $method->addParameter('input')
               ->setTypeHint(InputInterface::class);
        $method->addParameter('output')
               ->setTypeHint(OutputInterface::class);
        $method->setBody(
            '
        $io = new SymfonyStyle($input, $output);
    try {
        
        //todo: write your code
        
    } catch (Exception $exception) {
        $io->error($exception->getMessage());
    }'
        );

        $path = $this->getSourcePath().'/Command/'.$this->getFullClass($name).'.php';
        $fs   = new Filesystem();
        if ($fs->exists($path)) {
            throw new Exception(sprintf('File "%s" exist', $path));
        }

        $fs->appendToFile($path, '<?php '.PHP_EOL);
        $fs->appendToFile($path, $namespace);
        $io->success(sprintf('Command \'%s\' is create', $name));
    }

    private function getBlockName(SymfonyStyle $input)
    {
        if ($name = $input->ask('Enter command name', "custom:name")) {
            return $name;
        } else {
            return $this->getBlockName($input);
        }
    }

    public function getClass(string $name)
    {
        $name        = ChangeCase::pascal($name);
        $isValidName = preg_match('/^([a-zA-Z].+)Command$/', $name, $match);
        if ($isValidName) {
            return $match[ '1' ];
        }

        return $name;
    }

    public function getFullClass(string $name)
    {

        return $this->getClass($name).'Command';
    }

    private function getNamespace()
    {
        return $this->getConfigs()[ 'namespace' ].'Command';
    }

}
