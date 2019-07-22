<?php


namespace Sau\WP\Core\Command;


use Exception;
use Sau\WP\Core\Exceptions\BaseCoreException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Style\StyleInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

trait MakeClassTrait
{
    /**
     * @var string
     */
    private $class;
    /**
     * @var string
     */
    private $namespace;
    /**
     * @var string
     */
    private $projectNamespace = '';
    /**
     * @var string
     */
    private $expectedClass;
    /**
     * @var string
     */
    private $sourcePath;

    /**
     * @param StyleInterface $style
     * @param string         $question Question for generator
     * @param string         $default  Default value
     *
     * @return string
     * @throws BaseCoreException
     */
    public function creteClass(
        StyleInterface $style,
        string $question = 'Enter namespace',
        string $default = 'CustomClassName'
    ): string {
        if ( ! $this->expectedClass) {
            $this->expectedClass = $style->ask($question, $default,);
        }
        $this->parseNamespace();

        return $this->generate($style);
    }

    /**
     * @return mixed
     * @throws BaseCoreException
     */
    public function parseNamespace()
    {
        if ( ! $this->getExpectedClass()) {
            throw new BaseCoreException('The expected class name is empty');
        }
        preg_match(
            '/^((?<namespace>[A-Z][\w\\\\]+)\\\\)*(?<class>[A-Z]\w+)$/',
            preg_quote($this->getExpectedClass()),
            $matches
        );

        $this->namespace = $matches[ 'namespace' ];
        $this->class     = $matches[ 'class' ];

        return $matches;
    }

    /**
     * 'Project' namespace + 'Asc' namespace
     * @return string
     * @throws BaseCoreException
     */
    public function getFullNamespace()
    {
        return trim($this->getProjectNamespace().'\\'.$this->getNamespace(), '\\');
    }

    /**
     * @param string $projectNamespace
     *
     * @return self
     */
    public function setProjectNamespace(string $projectNamespace): self
    {
        $this->projectNamespace = $projectNamespace;

        return $this;
    }

    /**
     * Namespace in project
     * @return string
     */
    public function getProjectNamespace(): string
    {
        return trim($this->projectNamespace, '\\');
    }

    /**
     * Class in asc
     * @return string
     * @throws BaseCoreException
     */
    public function getClass(): string
    {
        if ( ! $this->class) {
            $this->parseNamespace();
        }

        return $this->class;
    }

    /**
     * Namespace in asc
     * @return string
     * @throws BaseCoreException
     */
    public function getNamespace(): string
    {
        if ( ! $this->namespace) {
            $this->parseNamespace();
        }

        return $this->namespace;
    }

    /**
     * Asc result
     * @return string
     */
    public function getExpectedClass(): string
    {
        return $this->expectedClass;
    }

    /**
     * Path to source file
     * @return string
     * @throws BaseCoreException
     */
    public function getSourcePath(): string
    {
        if (!$this->sourcePath){
            throw new BaseCoreException('The source path is empty');
        }
        return $this->sourcePath;
    }

    /**
     * @param string $sourcePath
     *
     * @return self
     */
    public function setSourcePath(string $sourcePath): self
    {
        $this->sourcePath = $sourcePath;

        return $this;
    }

    public function fileClassExist():bool
    {

}

    /**
     * @return string
     * @throws BaseCoreException
     */
    public function getPathToSave()
    {
        dump($this->getNamespace());
        return $this->getSourcePath().trim(str_replace('\\','/',$this->getNamespace()),'/').$this->getExpectedClass();

}

    public function saveClass()
    {

    }
    /**
     *
     * Method for generate class or namespace
     *
     * @param StyleInterface $style
     *
     * @return string
     */
    abstract public function generate(StyleInterface $style): ?string;
}
