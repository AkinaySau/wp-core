<?php
/**
 * Created by PhpStorm.
 * User: sau
 * Date: 05.03.18
 * Time: 10:48
 */

namespace Sau\WP\Core\DependencyInjection\Collector;


use Carbon_Fields\Carbon_Fields;
use Symfony\Component\DependencyInjection\ContainerInterface;

class CarbonCollector
{
    /**
     * @var array
     */
    private $containers;
    /**
     * @var array
     */
    private $blocks;
    /**
     * @var array
     */
    private $configs;

    public function __construct(array $configs, $containers)
    {
        $this->configs    = $configs;
        $this->containers = $containers;
    }

    /**
     * @return array
     */
    public function getContainers(): array
    {
        return $this->containers;
    }

    /**
     * @return array
     */
    public function getBlocks(): array
    {
        return $this->blocks;
    }

    /**
     * @return array
     */
    public function getConfigs(): array
    {
        return $this->configs;
    }

}
