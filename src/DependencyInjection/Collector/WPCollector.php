<?php


namespace Sau\WP\Core\DependencyInjection\Collector;


class WPCollector
{
    /**
     * @var array
     */
    private $configs;
    /**
     * @var array|null
     */
    private $actions;

    public function __construct(array $configs, ?array $actions)
    {
        $this->configs = $configs;
        $this->actions = $actions;
    }

    /**
     * @return array
     */
    public function getConfigs(): array
    {
        return $this->configs;
    }

    /**
     * @param string $val
     *
     * @return mixed
     */
    public function getConfig(string $val)
    {
        if (array_key_exists($val, $this->getConfigs())) {
            return $this->getConfigs()[ $val ];
        }

        return null;
    }

    /**
     * @return array|null
     */
    public function getActions(): ?array
    {
        return $this->actions;
    }
}
