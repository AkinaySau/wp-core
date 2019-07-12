<?php
/**
 * Created for cartest.
 * User: AkinaySau akinaysau@gmail.ru
 * Date: 26.09.2017
 * Time: 13:45
 */

namespace Sau\WP\Core\TwigExtension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class CarbonExtension extends AbstractExtension
{

    public function getFunctions()
    {
        $functions = [];
        if (function_exists('carbon_get_term_meta')) {
            $functions[] = new TwigFunction('crb_term', 'carbon_get_term_meta');
        }
        if (function_exists('carbon_get_post_meta')) {
            $functions[] = new TwigFunction('crb_post', 'carbon_get_post_meta');
        }
        if (function_exists('carbon_get_comment_meta')) {
            $functions[] = new TwigFunction('crb_com', 'carbon_get_comment_meta');
        }
        if (function_exists('carbon_get_nav_menu_item_meta')) {
            $functions[] = new TwigFunction('crb_nav', 'carbon_get_nav_menu_item_meta');
        }
        if (function_exists('carbon_get_user_meta')) {
            $functions[] = new TwigFunction('crb_user', 'carbon_get_user_meta');
        }
        if (function_exists('carbon_get_the_post_meta')) {
            $functions[] = new TwigFunction('crb_the_post', 'carbon_get_the_post_meta');
        }
        if (function_exists('carbon_get_theme_option')) {
            $functions[] = new TwigFunction('crb_theme', 'carbon_get_theme_option');
        }
        $functions[] = new TwigFunction(
            'crb_test', function ($i) {
            echo (string)$i;
        }
        );
        return $functions;
    }
}
