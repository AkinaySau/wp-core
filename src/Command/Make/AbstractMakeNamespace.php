<?php


namespace Sau\WP\Core\Command\Make;


use Nette\PhpGenerator\PhpNamespace;
use Nette\PhpGenerator\PsrPrinter;
use Sau\WP\Core\Exceptions\ConfigurationSettingsNotFoundException;
use Sau\WP\Core\Exceptions\Console\FileClassExistException;
use Sau\WP\Core\Exceptions\Console\MakeNamespaceException;
use Symfony\Component\Console\Style\StyleInterface;
use Symfony\Component\Filesystem\Filesystem;

abstract class AbstractMakeNamespace extends AbstractMake
{
    /**
     * @var PhpNamespace
     */
    private $namespace;
    /**
     * @var Filesystem
     */
    private $fs;
    /**
     * @var string
     */
    private $expectedClass;

    public function __construct(StyleInterface $style, array $options)
    {
        parent::__construct($style, $options);
        $this->fs        = new Filesystem();
        $this->namespace = $this->generate();
    }

    /**
     * todo need create automaker
     *
     * @param bool $rewrite
     *
     * @return mixed
     * @throws ConfigurationSettingsNotFoundException
     * @throws FileClassExistException
     * @throws MakeNamespaceException
     */
    public function save($rewrite = false)
    {
        if (count($this->namespace->getClasses()) > 1) {
            throw new MakeNamespaceException();
        }

        $keys = array_keys($this->namespace->getClasses());

        $className = $keys[ 0 ];
        $filename  = $className.'.php';
        $fullPath  = $this->pathAbsolute().DIRECTORY_SEPARATOR.$filename;
        if ( ! $rewrite && $this->fs->exists($fullPath)) {
            throw new FileClassExistException($className);
        }
        $printer   = new PsrPrinter();
        $namespace = $printer->printNamespace($this->namespace);

        $this->fs->appendToFile($fullPath, '<?php '.PHP_EOL.$namespace);
    }

    abstract protected function generate(): PhpNamespace;


    /**
     * @param $expectedNamespace
     *
     * @return string
     * @throws ConfigurationSettingsNotFoundException
     */
    public function namespaceAbsolute($expectedNamespace)
    {
        $forMerge = [
            trim($this->getOptions('namespace'), '\\'),
            trim($this->pathPrefix(), '\\'),
            trim($expectedNamespace, '\\'),

        ];

        return trim(implode('\\', $forMerge), '\\');

    }

    /**
     * Return absolute path Namespace
     * @return string
     * @throws ConfigurationSettingsNotFoundException
     */
    public function pathAbsolute()
    {
        return $this->getOptions('src').DIRECTORY_SEPARATOR.$this->pathRelative();
    }

    /**
     * Return path source in project
     *
     * @return string
     * @throws ConfigurationSettingsNotFoundException
     */
    public function pathRelative()
    {
        $tmp = str_replace($this->getOptions('namespace'), '', $this->namespace->getName());

        return trim(str_replace('\\', '/', $tmp), '/');
    }

    /**
     * Return prefix if need save in inner catalog
     *
     * @return string
     */
    public function pathPrefix(): string
    {
        return '';
    }

    /**
     * Run asc for getting classname
     *
     * @param string $question
     * @param string $default
     *
     * @return string Expected classname with namespace
     */
    public function ascExpectedClass(
        string $question = 'Enter namespace',
        string $default = 'NS\CustomClassName'
    ): string {
        do {
            $expectedClass = $this->getStyle()
                                  ->ask($question, $default);

        } while ( ! $expectedClass);

        return $expectedClass;

    }

    /**
     * @param string $expectedClass
     *
     * @return mixed
     */
    public function parseNamespace(string $expectedClass): array
    {
        preg_match(
            '/^((?<namespace>[A-Z][\w\\\\]+)\\\\)*(?<class>[A-Z]\w+)$/',
            preg_quote($expectedClass),
            $matches
        );

        $matches = [
            str_replace('\\\\', '\\', trim($matches[ 'namespace' ], '\\')),
            $matches[ 'class' ],
        ];

        return $matches;
    }

    /**
     * @return PhpNamespace
     */
    public function getNamespace(): PhpNamespace
    {
        return $this->namespace;
    }


}
