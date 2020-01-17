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
            new TwigFilter('__', [$this, 'trans']),
            new TwigFilter('trans', [$this, 'trans']),
        ];
    }

    public function trans($var)
    {
        if (getenv('PLUGIN_TEXTDOMAIN')) {
            return __($var, getenv('PLUGIN_TEXTDOMAIN'));
        } else {
            return __($var);
        }
    }
}
