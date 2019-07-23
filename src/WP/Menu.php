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
    /**
     * @var array|null
     */
    private $domain;

    /**
     * @return array|null
     */
    public function getMenus(): ?array
    {
        return $this->menus;
    }
    public function __construct()
    {
        dump(WP::getDomain());
//        $this->menus = $menus;
//        $this->domain = $domain;
    }

    setup /**
 * @param array|null $menus
 */
    public function setMenus(?array $menus): void
    {
        $this->menus = $menus;
    }

    function action()
    {/*
        if (count($this->menus)) {
            add_action(
                'after_setup_theme',
                function () {
                    register_nav_menus($this->menus);
                }
            );
        }*/
    }
}
