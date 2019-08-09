<?php


namespace Sau\WP\Core\Exceptions\CarbonExtension;


use Sau\WP\Core\Exceptions\BaseCoreException;

class IdIsNotTransmittedException extends BaseCoreException
{
    public function __construct(string $class)
    {
        $message = sprintf('Id is not transmitted(%s)', $class);
        parent::__construct($message);
    }
}
