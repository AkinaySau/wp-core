<?php


namespace Sau\WP\Core\Command;


trait MakeTrait
{
    protected function getSourcePath(): string
    {
        return $this->getBasePath().DIRECTORY_SEPARATOR.$this->getConfigs()[ 'src' ];
    }
}
