<?php


namespace Sau\WP\Core\Command;

use Carbon_Fields\Container\Container as CarbonBaseContainer;
use Carbon_Fields\Field;
use Nette\PhpGenerator\PhpNamespace;
use Sau\WP\Core\Carbon\Container;
use Sau\WP\Core\Carbon\ContainerType;
use Sau\WP\Core\Exceptions\BaseCoreException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\StyleInterface;

class MakeCarbonContainerCommand extends AbstractMakeCommand
{
    use MakeClassTrait;
    protected static $defaultName = 'make:carbon:container';

    private $className;

    private $namespace;

    protected function configure()
    {
        $this->setDescription('Generate new carbon container');
    }

    protected function make(InputInterface $input, OutputInterface $output, StyleInterface $style)
    {
        $this->setProjectNamespace(trim($this->getConfigs()[ 'namespace' ], '\\').'\Carbon');

        $class = $this->creteClass($style);

        $this->setSourcePath(
            $this->getBasePath().DIRECTORY_SEPARATOR.$this->getConfigs()[ 'src' ].DIRECTORY_SEPARATOR.'Carbon'
        );
        //        $this->fileClassExist()
        //        $this->saveClass();
        dump($this->getConfigs(),);
        dump($this->getPathToSave());

        //        $this->setSourcePath($this->getConfigs()[ 'src' ]);
        //        $this->saveClass($class);

        die($class);
        /*
                $path = $this->getSourcePath().'/Command/'.$this->getFullClass($name).'.php';
                $fs   = new Filesystem();
                if ($fs->exists($path)) {
                    throw new Exception(sprintf('File "%s" exist', $path));
                }

                $fs->appendToFile($path, '<?php '.PHP_EOL);
                $fs->appendToFile($path, $namespace);
                $style->success(sprintf('Command \'%s\' is create', $name));*/
    }

    /**
     *
     * Method for generate class or namespace
     *
     *
     * @param StyleInterface $style
     *
     * @return string
     * @throws BaseCoreException
     */
    public function generate(StyleInterface $style): string
    {

        $namespace = new PhpNamespace($this->getFullNamespace());
        $namespace->addUse(CarbonBaseContainer::class, 'CarbonBaseContainer');
        $namespace->addUse(Field::class);
        $namespace->addUse(Container::class);

        $class = $namespace->addClass($this->getClass().'Container');
        $class->addExtend(Container::class);

        ### Setup type ###
        $types = [
            ContainerType::THEME_OPTIONS => 'Theme options container',
            ContainerType::POST_META     => 'Container for posts',
            ContainerType::TERM_META     => 'Container for terms',
            ContainerType::COMMENT_META  => 'Container for comments',
            ContainerType::NAV_MENU_ITEM => 'Container for menu items',
            ContainerType::USER_META     => 'Container for users',
        ];
        $type  = $style->choice('Choice type container', $types);
        $class->addMethod('getType')
              ->setComment($types[ $type ])
              ->setReturnType('string')
              ->setBody(sprintf('return \'%s\';', $type));
        ### End ###

        ### Setup title ###
        $title = $style->ask('Enter title');
        if ( ! $title) {
            $style->warning('Skip!');
            die();
        }
        $class->addMethod('getTitle')
              ->setReturnType('string')
              ->setBody(sprintf('return \'%s\';', $title));
        ### End ###

        ### Setup type ###
        $class->addMethod('getFields')
              ->setReturnType('array')
              ->setBody('return [];');
        ### End ###

        $outputClass = '<?php'.PHP_EOL.$namespace;

        return $outputClass;
    }
}
