<?php
namespace WBlib;

use RD;
use SessionData\SessionData;
use WBlib\Error\Error;

class Route
{
    public static $get = [];
    public static $post = [];

    public static function useRedis (){
        SessionData::$redis = true;

        RD::create();
    }

    public static function response($result, $code = 200)
    {
        http_response_code($code);

        if (gettype($result) === "array") {
            if (Settings::isApiModeAllowed()) { header('Content-Type: application/json; charset=utf-8'); }

            echo json_encode($result);
        } elseif (gettype($result) === "boolean") {
            echo ($result) ? "true" : "false";
        } elseif ($result !== null) {
            echo $result;
        }

        exit();
    }

    public static function get($route, ...$params)
    {
        $_route = ($route === '/') ? $route : ((substr($route, -1) === '/') ? substr($route, 0, -1) : $route);

        if (empty($params)) {
            Error::fatalError("Route GET \"$route\" needs to have some function to process request!");
        }

        static::$get[$_route] = $params;
    }

    public static function post($route, ...$params)
    {
        $_route = ($route === '/') ? $route : ((substr($route, -1) === '/') ? substr($route, 0, -1) : $route);

        if (empty($params)) {
            Error::fatalError("Route POST \"$route\" needs to have some function to process request!");
        }

        static::$post[$_route] = $params;
    }

    public static function route()
    {
        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            $url = (strtok($_SERVER["REQUEST_URI"], '?') === '/') ? strtok($_SERVER["REQUEST_URI"], '?') 
                : ((substr(strtok($_SERVER["REQUEST_URI"], '?'), -1) === '/') ? substr(strtok($_SERVER["REQUEST_URI"], '?'), 0, -1) : strtok($_SERVER["REQUEST_URI"], '?'));

            if (array_key_exists($url, static::$get)) {
                $numFuncs = count(static::$get[$url]);
                $i = 0;

                foreach (static::$get[$url] as $func) {
                    if (++$i === $numFuncs) {
                        $result = $func();

                        static::response($result);
                        break;
                    }

                    $func();
                }
            } else {
                Error::e404();
            }
        } elseif ($_SERVER["REQUEST_METHOD"] === "POST") {
            $url = ($_SERVER["REQUEST_METHOD"] === '/') ? $_SERVER["REQUEST_METHOD"] 
                : ((substr($_SERVER["REQUEST_URI"], -1) === '/') ? substr($_SERVER["REQUEST_URI"], 0, -1) : $_SERVER["REQUEST_URI"]);

            if (array_key_exists($url, static::$post)) {
                $numFuncs = count(static::$post[$url]);
                $i = 0;

                foreach (static::$post[$url] as $func) {
                    if (++$i === $numFuncs) {
                        $result = $func();

                        static::response($result);
                        break;
                    }

                    $func();
                }
            } else {
                Error::e404();
            }
        } elseif ($_SERVER["REQUEST_METHOD"] === "HEAD") {
            http_response_code(200);

            exit();
        } else {
            Error::e501();
        }
    }
}