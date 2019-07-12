<?php
/**
 * Created by PhpStorm.
 * User: sau
 * Date: 05.03.18
 * Time: 10:48
 */

namespace Sau\WP\Core\Carbon;


use Carbon_Fields\Carbon_Fields;

class Carbon
{
    public function __construct($options = [])
    {
        #init carbon
        add_action(
            'after_setup_theme',
            function () {
                Carbon_Fields::boot();

            }
        );


    }

    public function registerContainers($services){}
    public function registerBlock($services){}

}
