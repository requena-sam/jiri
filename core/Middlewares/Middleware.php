<?php

namespace Core\Middlewares;

use Core\Exceptions\MiddlewareNotFoundException;

class Middleware
{
    private const MAP = [
        'csrf' => CSRF::class,
        'auth' => Auth::class,
        'guest' => Guest::class,
    ];

    public static function resolve(string $name): void
    {
        if(!array_key_exists($name,self::MAP)){
            throw new MiddlewareNotFoundException($name);
        }

        $name = self::MAP[$name];
        (new $name())->handle();

    }
}