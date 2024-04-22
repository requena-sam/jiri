<?php

namespace Core;

use JetBrains\PhpStorm\NoReturn;

class Response
{
    public const BAD_REQUEST = 400;
    public const NOT_FOUND = 404;
    public const SEE_OTHER = 303;
    public const SERVER_ERROR = 500;

    #[NoReturn] public static function abort(int $code = self::NOT_FOUND): void
    {
        http_response_code($code);
        view("codes.{$code}");
        die();
    }

    #[NoReturn] public static function redirect(string $url): void
    {
        http_response_code(self::SEE_OTHER);
        header('location: '.$url);
        die();
    }
}