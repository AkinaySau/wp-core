<?php


namespace Sau\WP\Core\Command\Make;


use Carbon_Fields\Container\Container as CarbonBaseContainer;
use Carbon_Fields\Field;
use ChangeCase\ChangeCase;
use Nette\PhpGenerator\PhpNamespace;
use Sau\WP\Core\Carbon\Container;
use Sau\WP\Core\Carbon\ContainerType;
use Sau\WP\Core\Carbon\Generator;
use Sau\WP\Core\Carbon\GutenbergBlock;

class GutenbergContainerMake extends AbstractMakeNamespace
{
    /**
     * @var string
     */
    private $template;

    /**
     * @return string
     */
    public function getTemplate(): string
    {
        return $this->template;
    }

    protected function generate(): PhpNamespace
    {
        $expectedClass = $this->ascExpectedClass('Enter class name for create gutenberg block', 'CustomClassName');

        list($namespace, $class) = $this->parseNamespace($expectedClass);
        $this->setTemplate($namespace, $class);
        $namespace = new PhpNamespace($this->namespaceAbsolute($namespace));

        $namespace->addUse(Field::class);
        $namespace->addUse(GutenbergBlock::class);

        $class = $namespace->addClass($class);
        $class->addExtend(GutenbergBlock::class);

        ### Setup title ###
        do {
            if (isset($title)) {
                $this->getStyle()
                     ->error(sprintf('Value "%s" is invalid', $title));
            }
            $title = $this->getStyle()
                          ->ask('Enter title block') ?? '';
        } while ( ! $title);


        $class->addMethod('getTitle')
              ->setReturnType('string')
              ->setBody(sprintf('return \'%s\';', $title));
        ### End ###

        ### Setup template ###
        $class->addMethod('getTemplate')
              ->setReturnType('string')
              ->setBody(sprintf('return \'%s\';', $this->getTemplateNamespace()));
        ### End ###

        ### Setup type ###
        $generator = new Generator($this->getStyle());
        $generator->start();

        $fields = $generator->getFields();

        $class->addMethod('getFields')
              ->setReturnType('array')
              ->setBody(sprintf('return [%s];', $fields));

        ### End ###


        return $namespace;
    }

    public function pathPrefix(): string
    {
        return 'Carbon\Block'; // TODO: Change the autogenerated stub
    }

    private function getTemplateNamespace()
    {
        return sprintf('@s-core/%s', $this->template);
    }

    /**
     * @param string $namespace
     * @param string $class
     */
    public function setTemplate(string $namespace, string $class): void
    {

        $namespace = explode('\\', $namespace);
        $namespace = array_map(
            function ($item) {
                return ChangeCase::kebab($item);
            },
            $namespace
        );

        $this->template = 'block/'.implode(DIRECTORY_SEPARATOR, $namespace).DIRECTORY_SEPARATOR.ChangeCase::kebab(
                $class
            ).'.html.twig';
    }
}
