<?php


namespace Sau\WP\Core\TwigExtension;


use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class BaseExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('dump', [$this, 'dump']),
        ];
    }

    public function dump(...$vars)
    {
        foreach ($vars as $var) {
            dump($var);
        }
    }
}
