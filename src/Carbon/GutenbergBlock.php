<?php


namespace Sau\WP\Core\Carbon;


use Sau\WP\Core\Twig\Twig;

abstract class GutenbergBlock extends Container
{
    protected $twig;

    public function __construct(Twig $twig)
    {
        $this->twig = $twig;
    }

    /**
     * Register as block
     * @return string
     */
    final public function getType(): string
    {
        return ContainerType::BLOCK;
    }

    /**
     * Title block
     * @return string
     */
    abstract function getTitle(): string;

    abstract function getTemplate(): string;

    final public function init(): void
    {
        parent::init();
        $this->container->set_render_callback(
            function ($fields, $attributes, $inner_blocks) {
                //todo: add inner_blocks
                echo $this->twig->render($this->getTemplate(), $fields);
            }
        )
                        ->set_preview_mode($this->getPreviewMod())
                        ->add_fields($this->getFields());
    }

    /**
     * Fields for this block
     * @return array
     */
    abstract public function getFields(): array;

    /**
     * Setup preview mod
     * @return bool
     */
    protected function getPreviewMod(): bool
    {
        return false;
    }
}
