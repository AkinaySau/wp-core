<?php


namespace Sau\WP\Core\Carbon\Logic;


class PostMetaLogic extends GeneralLogic
{

    static public function getTypes(): array
    {
        return array_merge(
            [
                'post_format'      => 'Check against the post format. Use a blank string as the value to test if the post has no format assigned.',
                'post_id'          => 'Check against the post id.',
                'post_level'       => 'Check against the post level in the hierarchy. Levels start from 1.',
                'post_parent_id'   => 'Check against the post\'s parent id.',
                'post_ancestor_id' => 'Check against the post\'s ancestors.',
                'post_template'    => 'Check against the post\'s template filename. Pass default as the value to test against the default page template.',
                'post_term'        => 'Check against the post\'s terms. The expected value must be a term descriptor (see below). CUSTOM callable is passed the post\'s id.',
                'post_type'        => 'Check against the post\'s type.',
            ],
            parent::getTypes()
        );
    }
}
