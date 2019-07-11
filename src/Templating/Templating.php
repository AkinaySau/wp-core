<?php


namespace Sau\WP\Core\Templating;


use Sau\WP\Core\Templating\Engine\TwigEngine;
use Symfony\Component\Templating\DelegatingEngine;
use Symfony\Component\Templating\PhpEngine;
use Symfony\Component\Templating\TemplateNameParser;
use Twig\Loader\FilesystemLoader;

class Templating
{


    /**
     * @var string
     */
    private $template_path;

    public function getTemplating()
    {

        $templating = new PhpEngine(new TemplateNameParser(), $this->getTemplatePath());

        return $templating;
    }

    /**
     * @param string $template_path
     *
     */
    public function __construct(string $template_path)
    {
        $this->template_path = $template_path;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function getTemplatePath(): string
    {
        if ( ! $this->template_path) {
            throw new \Exception('not set template path');
        }

        return $this->template_path;
    }

}
