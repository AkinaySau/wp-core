<?php


namespace Sau\WP\Core\Command;

use Carbon_Fields\Container\Container as CarbonBaseContainer;
use Carbon_Fields\Field;
use ChangeCase\ChangeCase;
use Exception;
use Nette\PhpGenerator\PhpNamespace;
use Sau\WP\Core\Carbon\Container;
use Sau\WP\Core\Carbon\ContainerType;
use Sau\WP\Core\Traits\MakeClassTrait;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Filesystem\Filesystem;

class MakeCarbonContainerCommand extends AbstractMakeCommand
{
    use MakeTrait;
    use MakeClassTrait;
    protected static $defaultName = 'make:carbon:container';

    private $className;

    private $namespace;

    protected function configure()
    {
        $this->setDescription('Generate new carbon container');
    }

    protected function make(InputInterface $input, OutputInterface $output, SymfonyStyle $io)
    {
        $asc = $this->getBlockName($io);

        dump($this->parseNamespace($asc));
        die();

        $tmpNamespace = explode('\\', $asc);

        $title          = ChangeCase::upperFirst(ChangeCase::no($asc));
        $shortNamespace = $this->getShortNamespace($tmpNamespace);//valid
        $namespace      = $this->getNamespace($shortNamespace);//valid
        $class          = $this->getClass($tmpNamespace);
        $fullClass      = $this->getFullClass($class);
        $path           = $this->getSourcePath().'/Carbon/'.str_replace('\\', DIRECTORY_SEPARATOR, $shortNamespace);

        $io->table(
            ['name', 'val'],
            [
                ['$title', $title],
                ['$shortNamespace', $shortNamespace],
                ['$namespace', $namespace],
                ['$class', $class],
                ['$fullClass', $fullClass],
                ['$path', $path],
            ]
        );


        $namespace = new PhpNamespace($namespace);
        $namespace->addUse(CarbonBaseContainer::class, 'CarbonBaseContainer');
        $namespace->addUse(Field::class);
        $namespace->addUse(Container::class);
        //$namespace->addUse(ContainerType::class);

        $class = $namespace->addClass($fullClass);
        $class->addExtend(Container::class);

        //        ask('sdfsdf',['sdf','sdf','sdf','sdf','sdf','sdf']);


        $outputClass = '<?php'.PHP_EOL.$namespace;
        echo $outputClass;
        die();
        $namespace = $this->getNamespace();


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

    private function getBlockName(SymfonyStyle $io)
    {
        if ($name = $io->ask('Enter block class', "Test\CustomBlock")) {
            return $name;
        } else {
            return $this->getBlockName($io);
        }
    }

    public function getClass(array $tmp)
    {
        $tmp  = array_pop($tmp);
        $name = ChangeCase::pascal($tmp);

        $isValidName = preg_match('/^([a-zA-Z].+)Container$/', $name, $match);
        if ($isValidName) {
            return $match[ '1' ];
        }

        return $name;
    }

    public function getFullClass(string $class)
    {
        return $class.'Container';
    }

    private function getNamespace(string $shortNamespace)
    {
        return $this->getConfigs()[ 'namespace' ].'Carbon\\'.$shortNamespace;
    }

    private function getShortNamespace(array $tpl)
    {
        array_pop($tpl);

        return implode('\\', $tpl);
    }

    /**
     *
     * Method for generate class or namespace
     *
     * @return string
     */
    public function generate(): string
    {
        return
    }
}
