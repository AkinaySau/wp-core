<?php


namespace Sau\WP\Core\Exceptions\CarbonExtension;


use Sau\WP\Core\Exceptions\BaseCoreException;

class NotContainerException extends BaseCoreException
{
    public function __construct(string $class)
    {
        $message = sprintf('Class "%s" don`t instanceof ContainerInterface', $class);
        parent::__construct($message);
    }
}
