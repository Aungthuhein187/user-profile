<?php

namespace Helpers;

class HTTP
{
    static string $base = "http://localhost/project";

    static function redirect(string $path, string $queryParam = "")
    {
        $url = static::$base . $path;
        if ($queryParam) {
            $url .= "?$queryParam";
        }

        header("location: $url");
        exit();
    }
}
