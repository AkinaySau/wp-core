<?php


namespace Sau\WP\Core\WP\Action;


use Sau\WP\Core\DependencyInjection\WPExtension\ActionInterface;

class Taxonomy implements ActionInterface
{

    function action()
    {
        add_action(
            'init',
            function () {

            }
        );
    }

    public function configure(array $taxonomy_list)
    {

    }
}
