<?php


namespace Sau\WP\Core\ShortCode;


use ChangeCase\ChangeCase;
use ReflectionClass;
use ReflectionException;
use Sau\WP\Core\DependencyInjection\WPExtension\ActionInterface;
use Sau\WP\Core\Twig\Twig;

abstract class AbstractShortCode implements ActionInterface
{

    /**
     * @var string
     */
    private $name;
    /**
     * @var Twig
     */
    private $twig;

    public function __construct(Twig $twig)
    {
        try {
            $reflect    = new ReflectionClass($this);
            $this->name = ChangeCase::kebab($reflect->getShortName());
        } catch (ReflectionException $e) {
            $this->name = ChangeCase::kebab(get_class($this));
        }
        $this->twig = $twig;
    }

    final public function action()
    {
        //fix for console
        if (function_exists('add_shortcode')) {
            add_shortcode($this->name, [$this, 'execute']);
        }
    }


    abstract public function execute(array $atts, $content = null): string;

    /**
     * @param string $name
     *
     * @return AbstractShortCode
     */
    public function setName(string $name): AbstractShortCode
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return Twig
     */
    public function getTwig(): Twig
    {
        return $this->twig;
    }
}
