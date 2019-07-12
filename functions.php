<?php

if ($container->has('twig')) {

    global $twig;
    $twig = $container->get('twig');

    if ( ! function_exists('twig_render')) {
        function twig_render($name, array $parameters = [])
        {
            global $twig;

            return $twig->render($name, $parameters);
        }
    }

    if ( ! function_exists('twig_display')) {
        function twig_display($name, array $parameters = [])
        {
            global $twig;
            $twig->display($name, $parameters);
        }
    }
}
