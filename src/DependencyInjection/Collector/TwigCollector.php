<?php
/**
 * Created by PhpStorm.
 * User: sau
 * Date: 05.03.18
 * Time: 10:48
 */

namespace Sau\WP\Core\DependencyInjection\Collector;

class TwigCollector
{
    /**
     * @var array
     */
    private $extensions;
    /**
     * @var array
     */
    private $configs;

    public function __construct(array $configs, $extensions)
    {
        $this->configs    = $configs;
        $this->extensions = $extensions;
    }

    /**
     * @return array
     */
    public function getExtensions(): array
    {
        return $this->extensions;
    }

    /**
     * @return array
     */
    public function getConfigs(): array
    {
        return $this->configs;
    }

}
