<?php


namespace Sau\WP\Core\Carbon\Logic;


class GeneralLogic extends AbstractContainerLogic
{

    static public function getTypes(): array
    {
        return [
            'current_user_capability' => 'Check against the current user\'s capabilities. CUSTOM callable is passed the current user\'s id.',
            'current_user_id'         => 'Check against the current user\'s id.',
            'current_user_role'       => 'Check against the current user\'s role. CUSTOM callable is passed an array of all current user\'s roles.',
        ];
    }
}
