<?php
/**
 * Created by PhpStorm.
 * User: sau
 * Date: 05.03.18
 * Time: 11:10
 */

namespace Sau\WP\Core\Carbon;

use Carbon_Fields\Container\Container as CarbonBaseContainer;

abstract class Container implements ContainerInterface
{
    /**
     * @return string
     * @see ContainerType for get types
     */
    abstract public function getType(): string;

    abstract public function getTitle(): string;

    /**
     * @var CarbonBaseContainer
     */
    protected $container;

    /**
     * Create container
     *
     * @param string $type  Container type maybe: post_meta, term_meta, user_meta, theme_options, comment_meta, nav_menu_item
     * @param string $title Title for container
     *
     * @return void
     */
    public function init():void
    {
        $container = CarbonBaseContainer::factory($this->getType(), $this->getTitle());
        $this->configure($container);
        $this->container = $container;
    }

    /**
     * Return container
     *
     * @return CarbonBaseContainer
     */
    public function getContainer(): CarbonBaseContainer
    {
        return $this->container;
    }

    /**
     * Use this function for configure container
     *
     * @param CarbonBaseContainer $container
     *
     * @return mixed
     */
    protected function configure(CarbonBaseContainer $container)
    {
    }

}
