<?php


namespace Sau\WP\Core\Exceptions\Console;


use Sau\WP\Core\Exceptions\BaseCoreException;

class FileClassExistException extends BaseCoreException
{
    public function __construct(string $class)
    {
        $message = sprintf('File for class "%s" exist', $class);
        parent::__construct($message);
    }
}
