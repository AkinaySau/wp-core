<?php


namespace Sau\WP\Core\Command\Make;

use Sau\WP\Core\Exceptions\ConfigurationSettingsNotFoundException;
use Symfony\Component\Console\Style\StyleInterface;

abstract class AbstractMake
{
    /**
     * @var StyleInterface
     */
    private $style;
    /**
     * @var array
     */
    private $options;

    public function __construct(StyleInterface $style, array $options)
    {
        $this->style   = $style;
        $this->options = $options;
    }

    /**
     * @return StyleInterface
     */
    public function getStyle(): StyleInterface
    {
        return $this->style;
    }

    /**
     * @param string|null $name
     *
     * @return array|string
     * @throws ConfigurationSettingsNotFoundException
     */
    public function getOptions(?string $name = null)
    {
        if ($name && array_key_exists($name, $this->options)) {
            return $this->options[ $name ];
        } elseif ($name && ! array_key_exists($name, $this->options)) {
            throw new ConfigurationSettingsNotFoundException($name);
        } else {
            return $this->options;
        }
    }
}
