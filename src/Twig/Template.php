<?php


namespace Sau\WP\Core\Twig;


class Template
{
    /**
     * @var TwigEngine
     */
    private $twig;

    public function __construct(TwigEngine $engine)
    {
        $this->twig = $engine;
    }

    public function render($name, array $parameters = [])
    {
        return $this->twig->render($name, $parameters);
    }

    public function display($name, array $parameters = [])
    {
        $this->twig->display($name, $parameters);
    }
}
