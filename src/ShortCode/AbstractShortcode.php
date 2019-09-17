<?php


namespace Sau\WP\Core\ShortCode;


use ReflectionClass;
use Sau\WP\Core\DependencyInjection\WPExtension\ActionInterface;

abstract class AbstractShortCode implements ActionInterface
{

    /**
     * @var string
     */
    private $name;

    public function __construct()
    {
        try {
            $reflect    = new ReflectionClass($this);
            $this->name = $reflect->getShortName();
        } catch (\ReflectionException $e) {

        }
    }

    final public function action()
    {
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
}
