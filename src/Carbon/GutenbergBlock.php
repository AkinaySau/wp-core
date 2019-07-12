<?php


namespace Sau\WP\Core\Carbon;


use Carbon_Fields\Block;
use Carbon_Fields\Container\Container;
use Sau\WP\Core\Twig\TwigEngine;
use Sau\WP\Theme\Extension\Carbon\CarbonActions;

abstract class GutenbergBlock implements CarbonInitInterface
{
    protected $twig;

    public function __construct(TwigEngine $twig)
    {
        $this->twig = $twig;
    }

    /**
     * Title block
     * @return string
     */
    abstract function getTitle(): string;

    abstract function getTemplate(): string;

    /**
     * block for smart configure
     */
    public function options()
    {
    }

    public function init()
    {
        $block = Block::make($this->getTitle());
        $block->set_render_callback(
                function ($fields, $attributes, $inner_blocks) {
                    echo $this->render($fields, $attributes, $inner_blocks);
                }
            )
              ->set_preview_mode($this->getPreviewMod())
              ->add_fields($this->getFields());
        $this->options($block);

        $obj = static::class;
        /*CarbonActions::carbonFieldsRegisterFields(
            function () use ($title, &$obj) {*/
        $obj = new $obj($title);
        //            }
        //        );
    }
}
