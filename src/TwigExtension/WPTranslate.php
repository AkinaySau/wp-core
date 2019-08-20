<?php


namespace Sau\WP\Core\TwigExtension;


use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class WPTranslate extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('__', '__'),
        ];
    }

}
