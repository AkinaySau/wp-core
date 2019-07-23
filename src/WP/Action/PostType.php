<?php


namespace Sau\WP\Core\WP\Action;


use Sau\WP\Core\DependencyInjection\WPExtension\ActionInterface;

class PostType implements ActionInterface
{

    function action()
    {
        add_action(
            'init',
            function () {

            }
        );
    }

    public function configure()
    {

    }
}
