<?php
namespace WBlib\Error;

use WBlib\Settings;

class Error
{
    const BadRequest = 400;
    const Forbidden = 403;
    const NotFound = 404;
    const InternalServerError = 500;
    const NotImplemented = 501;
    const ServiceUnavailable = 503;
    
    public static function fatalError($msg)
    {
        trigger_error($msg, E_USER_ERROR);
    }
    public static function warning($msg)
    {
        trigger_error($msg, E_USER_WARNING);
    }
    public static function notice($msg)
    {
        trigger_error($msg, E_USER_NOTICE);
    }
    public static function deprecated($msg)
    {
        trigger_error($msg, E_USER_DEPRECATED);
    }
    public static function e400($Umsg = null)
    {
        $code = static::BadRequest;
        $msg = ($Umsg !== null) ? $Umsg :
            "Server can not to process the request.";
        $Hmsg = (Settings::httpErrors[$code]["html"]["msg"]) ?
            $msg
            : "";

        $html = (Settings::httpErrors[$code]["html"] !== false) ? Settings::httpErrors[$code]["html"]["file"] : false;

        if ($html !== false) {
            global $_error_code, $_error_h, $_error_msg, $_error_redirect;

            $_error_code = Settings::httpErrors[$code]["html"]["code"];
            $_error_h = Settings::httpErrors[$code]["html"]["h"];
            $_error_msg = $Hmsg;
            $_error_redirect = Settings::httpErrors[$code]["html"]["redirect"];
        }

        $msg = (Settings::httpErrors[$code]["msg"]) ? $msg : "";

        http_response_code($code);

        if (!Settings::isApiModeAllowed() and $html !== false) {
            include(__DIR__ . "/../.." . $html);

            die();
        }

        if (Settings::isApiModeAllowed()) {
            header('Content-Type: application/json; charset=utf-8');

            echo json_encode(
                [
                    "status" => false,
                    "code" => $code,
                    "message" => $msg
                ]
            );
        }

        die();
    }
    public static function e501($Umsg = null)
    {
        $code = static::NotImplemented;
        $msg = ($Umsg !== null) ? $Umsg :
            "Http type - \"" . $_SERVER["REQUEST_METHOD"] . "\" is not supported.";
        $Hmsg = (Settings::httpErrors[$code]["html"]["msg"]) ?
            $msg
            : "";

        $html = (Settings::httpErrors[$code]["html"] !== false) ? Settings::httpErrors[$code]["html"]["file"] : false;

        if ($html !== false) {
            global $_error_code, $_error_h, $_error_msg, $_error_redirect;

            $_error_code = Settings::httpErrors[$code]["html"]["code"];
            $_error_h = Settings::httpErrors[$code]["html"]["h"];
            $_error_msg = $Hmsg;
            $_error_redirect = Settings::httpErrors[$code]["html"]["redirect"];
        }

        $msg = (Settings::httpErrors[$code]["msg"]) ? $msg : "";

        http_response_code($code);

        if (!Settings::isApiModeAllowed() and $html !== false) {
            include(__DIR__ . "/../.." . $html);

            die();
        }

        if (Settings::isApiModeAllowed()) {
            header('Content-Type: application/json; charset=utf-8');

            echo json_encode(
                [
                    "status" => false,
                    "code" => $code,
                    "message" => $msg
                ]
            );
        }

        die();
    }
    public static function e404($Umsg = null)
    {
        $code = static::NotFound;
        $msg = ($Umsg !== null) ? $Umsg :
            "We can not find the route " . $_SERVER["REQUEST_METHOD"] . " - \"" . $_SERVER["REQUEST_URI"] . "\".";
        $Hmsg = (Settings::httpErrors[$code]["html"]["msg"]) ?
            $msg
            : "";

        $html = (Settings::httpErrors[$code]["html"] !== false) ? Settings::httpErrors[$code]["html"]["file"] : false;

        if ($html !== false) {
            global $_error_code, $_error_h, $_error_msg, $_error_redirect;

            $_error_code = Settings::httpErrors[$code]["html"]["code"];
            $_error_h = Settings::httpErrors[$code]["html"]["h"];
            $_error_msg = $Hmsg;
            $_error_redirect = Settings::httpErrors[$code]["html"]["redirect"];
        }

        $msg = (Settings::httpErrors[$code]["msg"]) ? $msg : "";

        http_response_code($code);

        if (!Settings::isApiModeAllowed() and $html !== false) {
            include(__DIR__ . "/../.." . $html);

            die();
        }

        if (Settings::isApiModeAllowed()) {
            header('Content-Type: application/json; charset=utf-8');

            echo json_encode(
                [
                    "status" => false,
                    "code" => $code,
                    "message" => $msg
                ]
            );
        }

        die();
    }
    public static function e503($Umsg = null)
    {
        $code = static::ServiceUnavailable;
        $msg = ($Umsg !== null) ? $Umsg :
            "Server is not available at the moment. Try again later!";
        $Hmsg = (Settings::httpErrors[$code]["html"]["msg"]) ?
            $msg
            : "";

        $html = (Settings::httpErrors[$code]["html"] !== false) ? Settings::httpErrors[$code]["html"]["file"] : false;

        if ($html !== false) {
            global $_error_code, $_error_h, $_error_msg, $_error_redirect;

            $_error_code = Settings::httpErrors[$code]["html"]["code"];
            $_error_h = Settings::httpErrors[$code]["html"]["h"];
            $_error_msg = $Hmsg;
            $_error_redirect = Settings::httpErrors[$code]["html"]["redirect"];
        }

        $msg = (Settings::httpErrors[$code]["msg"]) ? $msg : "";

        http_response_code($code);

        if (!Settings::isApiModeAllowed() and $html !== false) {
            include(__DIR__ . "/../.." . $html);

            die();
        }

        if (Settings::isApiModeAllowed()) {
            header('Content-Type: application/json; charset=utf-8');

            echo json_encode(
                [
                    "status" => false,
                    "code" => $code,
                    "message" => $msg
                ]
            );
        }

        die();
    }
    public static function e500($Umsg = null)
    {
        $code = static::InternalServerError;
        $msg = ($Umsg !== null) ? $Umsg :
            "Some kind of unknown error occurred on our server, so server can not to process your request!";
        $Hmsg = (Settings::httpErrors[$code]["html"]["msg"]) ?
            $msg
            : "";

        $html = (Settings::httpErrors[$code]["html"] !== false) ? Settings::httpErrors[$code]["html"]["file"] : false;

        if ($html !== false) {
            global $_error_code, $_error_h, $_error_msg, $_error_redirect;

            $_error_code = Settings::httpErrors[$code]["html"]["code"];
            $_error_h = Settings::httpErrors[$code]["html"]["h"];
            $_error_msg = $Hmsg;
            $_error_redirect = Settings::httpErrors[$code]["html"]["redirect"];
        }

        $msg = (Settings::httpErrors[$code]["msg"]) ? $msg : "";

        http_response_code($code);

        if (!Settings::isApiModeAllowed() and $html !== false) {
            include(__DIR__ . "/../.." . $html);

            die();
        }

        if (Settings::isApiModeAllowed()) {
            header('Content-Type: application/json; charset=utf-8');

            echo json_encode(
                [
                    "status" => false,
                    "code" => $code,
                    "message" => $msg
                ]
            );
        }

        die();
    }
    public static function e403($Umsg = null)
    {
        $code = static::Forbidden;
        $msg = ($Umsg !== null) ? $Umsg :
            "You are not allowed to visit this page!.";
        $Hmsg = (Settings::httpErrors[$code]["html"]["msg"]) ?
            $msg
            : "";

        $html = (Settings::httpErrors[$code]["html"] !== false) ? Settings::httpErrors[$code]["html"]["file"] : false;

        if ($html !== false) {
            global $_error_code, $_error_h, $_error_msg, $_error_redirect;

            $_error_code = Settings::httpErrors[$code]["html"]["code"];
            $_error_h = Settings::httpErrors[$code]["html"]["h"];
            $_error_msg = $Hmsg;
            $_error_redirect = Settings::httpErrors[$code]["html"]["redirect"];
        }

        $msg = (Settings::httpErrors[$code]["msg"]) ? $msg : "";

        http_response_code($code);

        if (!Settings::isApiModeAllowed() and $html !== false) {
            include(__DIR__ . "/../.." . $html);

            die();
        }

        if (Settings::isApiModeAllowed()) {
            header('Content-Type: application/json; charset=utf-8');

            echo json_encode(
                [
                    "status" => false,
                    "code" => $code,
                    "message" => $msg
                ]
            );
        }

        die();
    }
}
