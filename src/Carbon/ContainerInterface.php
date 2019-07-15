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
}
