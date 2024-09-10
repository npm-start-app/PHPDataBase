<?php

use WBlib\Token;

class HtmlController
{
    const global_styles = '<link rel="stylesheet" href="http://localhost:5555/static/globals.css">';
    const styles = "http://localhost:5555/static/styles/";
    const scripts = "http://localhost:5555/static/scripts/";
    const http = "http://localhost:5555/static/scripts/http/http.js";
    const localSettings = "http://localhost:5555/static/scripts/LocalSettings/settings.js";
    const auther = "http://localhost:5555/static/scripts/Auther/auth.js";
    const domain = "http://localhost:5555/";

    public static function Home()
    {
        $styles = static::styles . "Home/";
        $scripts = static::scripts . "Home/";

        include("./static/pages/Home/index.php");

        return;
    }
    public static function Preauth() {
        $styles = static::styles . "Preauth/";
        $scripts = static::scripts . "Preauth/";

        include("./static/pages/Preauth/index.php");

        return;
    }
    public static function Auth()
    {
        $styles = static::styles . "Auth/";
        $scripts = static::scripts . "Auth/";

        $result = "";

        if (array_key_exists("code", $_GET)) {
            if ($_GET["code"] === "generateAdminToken") {
                AuthController::GenerateAdminToken();
            } else if ($_GET["code"] === "init") {
                $result = AuthController::Init();
            } else if ($_GET["code"] === "getToken") {
                AuthController::getAdminGeneratedToken();
            }
        }

        include("./static/pages/Auth/index.php");

        return $result;
    }
    public static function Account()
    {
        $styles = static::styles . "Account/";
        $scripts = static::scripts . "Account/";

        include("./static/pages/Account/index.php");

        return;
    }
    public static function Cmd()
    {
        $styles = static::styles . "Cmd/";
        $scripts = static::scripts . "Cmd/";

        include("./static/pages/Cmd/index.php");

        return;
    }
}