<?php


namespace Sau\WP\Core\Option;


use Exception;
use Sau\WP\Core\DependencyInjection\WPExtension\ActionInterface;

/**
 * Class AbstractPageOption
 * @package Sau\WP\Core\Option
 * @see     https://wp-kama.ru/function/add_options_page
 */
abstract class AbstractPageOption implements ActionInterface
{

    public function action()
    {
        add_action('admin_menu', [$this, 'register']);
        if (method_exists($this, 'settings')) {
            $this->settings();
        }
    }

    final public function register()
    {
        add_options_page(
            $this->getPageTitle(),
            $this->getMenuTitle(),
            $this->getCapability(),
            $this->getSlug(),
            [$this, 'page']
        );

    }

    abstract public function page(): void;

    /**
     * @return string
     */
    public function getPageTitle(): string
    {
        if ( ! defined('static::PAGE_TITLE')) {
            $message = sprintf('Constant %s is not set in %s', 'PAGE_TITLE', static::class);
            throw new Exception($message);
        }

        return static::PAGE_TITLE;
    }

    /**
     * @return string
     */
    public function getMenuTitle(): string
    {
        if ( ! defined('static::MENU_TITLE')) {
            $message = sprintf('Constant %s is not set in %s', 'MENU_TITLE', static::class);
            throw new Exception($message);
        }

        return static::MENU_TITLE;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        if ( ! defined('static::SLUG')) {
            $message = sprintf('Constant %s is not set in %s', 'SLUG', static::class);
            throw new Exception($message);
        }

        return static::SLUG;
    }

    protected function getCapability(): string
    {
        return 'manage_options';
    }


}
