<?php


namespace Sau\WP\Core\Exceptions;

class ConfigurationSettingsNotFoundException extends BaseCoreException
{
    public function __construct(string $option)
    {
        $message = sprintf('Configuration settings "%s" not found', $option);
        parent::__construct($message);
    }
}
