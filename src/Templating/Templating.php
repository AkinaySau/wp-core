<?php


namespace Sau\WP\Core\Templating;


use Sau\WP\Core\Templating\Engine\TwigEngine;
use Symfony\Component\Templating\DelegatingEngine;
use Symfony\Component\Templating\TemplateNameParser;
use Twig\Loader\FilesystemLoader;

class Templating
{


    /**
     * @var string
     */
    private $template_path;

    public function __construct(string $templatePath)
    {
        $this->template_path = $templatePath;

        dump($templatePath);
        die();
//        $filesystemLoader = new FilesystemLoader(__DIR__.'/views/%name%');
//        $templating = new DelegatingEngine(
//            [
//                new TwigEngine(new TemplateNameParser(), $filesystemLoader),
//            ]
//        );

    }
}
