<?php


namespace Sau\WP\Core\Twig;


use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class Twig
{
    /**
     * @var TwigEngine
     */
    private $environment;

    /**
     * Twig constructor.
     *
     * @param TwigEngine $engine
     *
     * @throws LoaderError
     */
    public function __construct(TwigEngine $engine)
    {
        $this->environment = $engine->getEnvironment();
    }

    /**
     * @param       $name
     * @param array $parameters
     *
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function render($name, array $parameters = [])
    {
        return $this->environment->render($name, $parameters);
    }

    /**
     * @param       $name
     * @param array $parameters
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function display($name, array $parameters = [])
    {
        $this->environment->display($name, $parameters);
    }
}
