<?php


namespace Sau\WP\Core\Twig;


use Twig\Environment;
use Twig\Loader\FilesystemLoader;

final class TwigEngine
{

    /**
     * @var Environment
     */
    private $twig;

    private $isRegisteredExtensions = false;

    public function __construct($template_path, $configs = [])
    {
        $loader = new FilesystemLoader();
        $loader->addPath($template_path, 's-core');
        $this->twig = new Environment(
            $loader, $configs
        );
    }

    public function registerExtensions($extensions)
    {
        if ($this->isRegisteredExtensions) {
            return;
        }
        foreach ($extensions as $class => $extension) {
            $this->twig->addExtension(new $class);
        }
        $this->isRegisteredExtensions = true;
    }

    public function render($name, array $parameters = [])
    {
        return $this->twig->render($name, $parameters);
    }

    public function display($name, array $parameters = [])
    {
        echo $this->render($name, $parameters);

    }

    /**
     * @return bool
     */
    public function isRegisteredExtensions(): bool
    {
        return $this->isRegisteredExtensions;
    }

}
