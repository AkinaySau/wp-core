<?php


namespace Sau\WP\Core\Carbon;


use Carbon_Fields\Field\Field;
use Sau\WP\Core\Exceptions\CarbonExtension\IdIsNotTransmittedException;
use Sau\WP\Core\Exceptions\CarbonExtension\NotContainerException;

/**
 * Trait DataTrait
 * @package Sau\WP\Core\Carbon
 * @method getFields()
 * @method getType()
 * @method getTitle()
 */
trait DataTrait
{
    /**
     * @param null $id
     *
     * @return array
     * @throws NotContainerException
     */
    public function getData($id = null)
    {
        if ( ! $this instanceof ContainerInterface) {
            throw new NotContainerException(get_class($this));
        }
        $fields   = $this->getFields();
        $check_id = function () use ($id) {
            if (is_null($id)) {
                throw new IdIsNotTransmittedException(get_class($this));
            }
        };
        $vars     = [];
        /** @var Field $field */
        foreach ($fields as $field) {
            $name = $field->get_base_name();
            switch ($this->getType()):
                case ContainerType::POST_META:
                    if ($id) {
                        $val = carbon_get_post_meta($id, $name);
                    } else {
                        $val = carbon_get_the_post_meta($name);
                    }
                    break;
                case ContainerType::TERM_META:
                    $check_id();
                    $val = carbon_get_term_meta($id, $name);
                    break;
                case ContainerType::USER_META:
                    $check_id();
                    $val = carbon_get_user_meta($id, $name);
                    break;
                case ContainerType::COMMENT_META:
                    $check_id();
                    $val = carbon_get_comment_meta($id, $name);
                    break;
                case ContainerType::NAV_MENU_ITEM:
                    $check_id();
                    $val = carbon_get_nav_menu_item_meta($id, $name);
                    break;
                default:
                    $val = carbon_get_theme_option($name);
            endswitch;
            $vars [ $name ] = $val;
        }

        return $vars;
    }
}
