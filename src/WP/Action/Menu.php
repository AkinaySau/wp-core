<?php


namespace Sau\WP\Core\WP\Action;


use Sau\WP\Core\DependencyInjection\WPExtension\ActionInterface;

class Menu implements ActionInterface
{

    /**
     * @var array|null
     */
    private $menus;


    function action()
    {
        if (count($this->menus)) {
            add_action(
                'after_setup_theme',
                function () {
                    register_nav_menus($this->menus);
                }
            );
        }
    }

    public function configure($menus)
    {
        $this->menus = $menus;

    }
}
