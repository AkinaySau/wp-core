<?php


namespace Sau\WP\Core\Exceptions\Console;


use Sau\WP\Core\Exceptions\BaseCoreException;
use Throwable;

class MakeNamespaceException extends BaseCoreException
{
    public function __construct()
    {
        parent::__construct('In make namespace may by only one class');
    }
}
