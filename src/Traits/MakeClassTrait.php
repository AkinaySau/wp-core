<?php


namespace Sau\WP\Core\Traits;


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
    private $ask;

    /**
     * @param StyleInterface $style
     * @param string         $question Question for generator
     * @param string         $default  Default value
     *
     * @return string
     */
    public function creteClass(
        StyleInterface $style,
        string $question = 'Enter namespace',
        string $default = 'CustomClassName'
    ): string {
        $this->ask = $style->ask($question, $default);

        return $this->generate();
    }

    public function parseNamespace()
    {
        preg_match('/^((?<namespace>[A-Z][\w\\\\]+)\\\\)*(?<class>[A-Z]\w+)$/', preg_quote($this->getAsk()), $matches);

        $this->namespace = $matches[ 'namespace' ];
        $this->class     = $matches[ 'class' ];

        return $matches;
    }

    /**
     * 'Project' namespace + 'Asc' namespace
     * @return string
     */
    public function getFullNamespace()
    {
        return $this->getProjectNamespace().'\\'.$this->getNamespace();
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
        return $this->projectNamespace;
    }

    /**
     * Class in asc
     * @return string
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
    public function getAsk(): string
    {
        return $this->ask;
    }


    /**
     *
     * Method for generate class or namespace
     *
     * @return string
     */
    abstract public function generate(): string;
}
