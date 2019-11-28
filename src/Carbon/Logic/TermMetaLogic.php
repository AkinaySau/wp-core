<?php


namespace Sau\WP\Core\Carbon\Logic;


class TermMetaLogic extends GeneralLogic
{

    static public function getTypes(): array
    {
        return array_merge(
            [
                'term'          => 'Check against the term according to the supplied term descriptor. CUSTOM callable is passed the term\'s id.',
                'term_level'    => 'Check against the term\'s level in the hierarchy.',
                'term_parent'   => 'Check against the term\'s parent.',
                'term_ancestor' => 'Check against the term\'s ancestors.',
                'term_taxonomy' => 'Check against the term\'s taxonomy.',
            ],
            parent::getTypes()
        );
    }
}
