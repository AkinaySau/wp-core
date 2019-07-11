<?php


namespace Sau\WP\Core\Twig;


use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class WPExtension extends AbstractExtension
{
    /**
     * Returns a list of functions to add to the existing list.
     *
     * @return TwigFunction[]
     */
    public function getFunctions()
    {
        return [
            new TwigFunction(
                'wp_test', function ($i) {
                echo (string)$i;
            }
            ),
        ];
    }
}
