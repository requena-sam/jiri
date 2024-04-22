<?php

namespace Core\Exceptions;

class MiddlewareNotFoundException extends \Exception
{

    /**
     * @param  string  $name
     */
    public function __construct(string $name)
    {
        parent::__construct($name);
    }
}