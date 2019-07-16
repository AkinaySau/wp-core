<?php


namespace Sau\WP\Core\DependencyInjection\Collector;


class ConsoleCollector
{
    /**
     * @var array
     */
    private $configs;
    /**
     * @var array
     */
    private $commands;

    public function __construct(array $configs, array $commands)
    {

        $this->configs  = $configs;
        $this->commands = $commands;
    }

    /**
     * @return array
     */
    public function getConfigs(): array
    {
        return $this->configs;
    }

    /**
     * @return array
     */
    public function getCommandsIds(): array
    {
        $ids = [];
        foreach ($this->commands as $id => $item) {
            $ids[] = $id;
        }

        return $ids;
    }


}
