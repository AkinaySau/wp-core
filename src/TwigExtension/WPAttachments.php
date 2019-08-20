<?php


namespace Sau\WP\Core\TwigExtension;


use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class WPAttachments extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('wp_attach_img_alt', [$this, 'wp_attach_img_alt']),
            new TwigFilter('wp_attach_title', [$this, 'wp_attach_title']),
            new TwigFilter('wp_attach_caption', [$this, 'wp_attach_caption']),
            new TwigFilter('wp_attach_description', [$this, 'wp_attach_description']),
        ];
    }

    public function getFunctions()
    {
        return [
            /**
             * Attachment
             */ new TwigFunction('wp_attach_img_src', 'wp_get_attachment_image_url'),
            new TwigFunction('wp_get_attachment_link', 'wp_get_attachment_link'),
            new TwigFunction('wp_get_attachment_url', 'wp_get_attachment_url'),
        ];
    }

    public function wp_attach_img_alt(int $attachment_id)
    {
        return trim(
            strip_tags(get_post_meta($attachment_id, '_wp_attachment_image_alt', true))
        ) ?: $this->wp_attach_title($attachment_id);
    }


    public function wp_attach_title(int $attachment_id)
    {
        if ( ! $post = get_post($attachment_id)) {
            return false;
        }

        return $post->post_title;
    }

    public function wp_attach_caption(int $attachment_id)
    {
        if ( ! $post = get_post($attachment_id)) {
            return false;
        }

        return $post->post_excerpt;
    }

    public function wp_attach_description(int $attachment_id)
    {
        if ( ! $post = get_post($attachment_id)) {
            return false;
        }

        return $post->post_content;
    }
}
