<?php


namespace Sau\WP\Core\WP;


use Sau\Lib\Action;
use Sau\WP\Core\DependencyInjection\WPExtension\ActionInterface;

class Menu implements ActionInterface
{
    /**
     * @var array|null
     */
    private $menus;

    public function __construct(?array $menus)
    {
        if ($menus)
        $this->menus = $menus;

    }

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
}
