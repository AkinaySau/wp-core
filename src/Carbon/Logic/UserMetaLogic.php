<?php


namespace Sau\WP\Core\Carbon\Logic;


class UserMetaLogic extends GeneralLogic
{

    static public function getTypes(): array
    {
        return array_merge(
            [
                'user_capability' => 'Check against the user\'s capabilities. CUSTOM callable is passed the user\'s id.',
                'user_id'         => 'Check against the user\'s id.',
                'user_role'       => 'Check against the user\'s role. CUSTOM callable is passed an array of the user\'s roles.',
            ],
            parent::getTypes()
        );
    }
}
