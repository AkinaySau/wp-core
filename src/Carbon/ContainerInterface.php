<?php


namespace Sau\WP\Core\Carbon;


/**
 * Interface for register carbon containers
 * @package Sau\WP\Core\Carbon
 */
interface ContainerInterface
{
    /**
     * Use for make new container
     * @return void
     */
    public function init(): void;

    /**
     * Return fields array
     * @return array
     */
    public function getFields(): array;

    /**
     * Setup container type
     * @return string
     */
    public function getType(): string;

    /**
     * Setup title container
     * @return string
     */
    public function getTitle(): string;
}
