<?php


namespace Sau\WP\Core\Carbon\Logic;


class ThemeLogic extends GeneralLogic
{

    static public function getTypes(): array
    {
        return array_merge(
            [
                'blog_id' => 'Check against the current blog\'s id',
            ],
            parent::getTypes()
        );
    }
}
