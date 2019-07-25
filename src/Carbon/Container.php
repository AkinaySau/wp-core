<?php
/**
 * Created by PhpStorm.
 * User: sau
 * Date: 05.03.18
 * Time: 11:10
 */

namespace Sau\WP\Core\Carbon;

use Carbon_Fields\Container\Container as CarbonBaseContainer;
use ChangeCase\ChangeCase;
use ReflectionClass;
use ReflectionException;

abstract class Container implements ContainerInterface
{
    /**
     * @return string
     * @see ContainerType for get types
     */
    abstract public function getType(): string;

    abstract public function getTitle(): string;

    abstract public function getFields(): array;

    /**
     * @var CarbonBaseContainer
     */
    protected $container;

    /**
     * Create container
     *
     * @return void
     * @throws ReflectionException
     */
    public function init(): void
    {
        $container = CarbonBaseContainer::factory($this->getType(), $this->getContainerID(), $this->getTitle());
        $container->add_fields($this->getFields());
        $this->configure($container);
        $this->container = $container;
    }

    /**
     * Return container
     *
     * @return CarbonBaseContainer
     */
    public function getContainer(): CarbonBaseContainer
    {
        return $this->container;
    }

    /**
     * Use this function for configure container
     *
     * @param CarbonBaseContainer $container
     *
     * @return mixed
     */
    protected function configure(CarbonBaseContainer $container)
    {
    }

    /**
     * @return string
     * @throws ReflectionException
     */
    public function getContainerID(): string
    {
        $reflect = new ReflectionClass($this);

        return ChangeCase::kebab($reflect->getShortName());

    }

}
