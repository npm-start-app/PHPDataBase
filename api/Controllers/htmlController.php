<?php

use WBlib\Token;

class HtmlController
{
    const global_styles = '<link rel="stylesheet" href="https://php-data-base-8u7d8z0c8-npm-start-apps-projects.vercel.app/static/globals.css">';
    const styles = "https://php-data-base-8u7d8z0c8-npm-start-apps-projects.vercel.app/static/styles/";
    const scripts = "https://php-data-base-8u7d8z0c8-npm-start-apps-projects.vercel.app/static/scripts/";
    const http = "https://php-data-base-8u7d8z0c8-npm-start-apps-projects.vercel.app/static/scripts/http/http.js";
    const localSettings = "http://localhost:5555/https://php-data-base-8u7d8z0c8-npm-start-apps-projects.vercel.app/static/scripts/LocalSettings/settings.js";
    const auther = "https://php-data-base-8u7d8z0c8-npm-start-apps-projects.vercel.app/static/scripts/Auther/auth.js";
    const domain = "https://php-data-base-8u7d8z0c8-npm-start-apps-projects.vercel.app/";

    public static function Home()
    {
        $styles = static::styles . "Home/";
        $scripts = static::scripts . "Home/";

        include($_dir_ . "/static/pages/Home/index.php");

        return;
    }
    public static function Preauth() {
        $styles = static::styles . "Preauth/";
        $scripts = static::scripts . "Preauth/";

        include($_dir_ . "/static/pages/Preauth/index.php");

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

        include($_dir_ . "/static/pages/Auth/index.php");

        return $result;
    }
    public static function Account()
    {
        $styles = static::styles . "Account/";
        $scripts = static::scripts . "Account/";

        include($_dir_ . "/static/pages/Account/index.php");

        return;
    }
    public static function Cmd()
    {
        $styles = static::styles . "Cmd/";
        $scripts = static::scripts . "Cmd/";

        include($_dir_ . "/static/pages/Cmd/index.php");

        return;
    }
}
