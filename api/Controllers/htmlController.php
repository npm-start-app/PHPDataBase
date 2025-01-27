<?php

use SessionData\SessionData;
use WBlib\Settings;

class HtmlController
{
    public static function global_styles() {return '<link rel="stylesheet" href="' . static::domain() . 'static/globals.css">';}
    public static function domain() {return Settings::getFullDomain() . '/';}
    public static function styles() {return static::domain() . 'static/styles/';}
    public static function scripts() {return static::domain() . 'static/scripts/';}
    public static function http() {return static::domain() . 'static/scripts/http/http.js';}
    public static function localSettings() {return static::domain() . 'static/scripts/LocalSettings/settings.js';}
    public static function auther() {return static::domain() . 'static/scripts/Auther/auth.js';}
    public static function footer() {return '<link rel="stylesheet" href="' . static::domain() . 'static/styles/footer.css">';}
    public static function loader() {return '<link rel="stylesheet" href="' . static::domain() . 'static/styles/loader.css">';}
    public static function icon() {return '<link rel="icon" type="image/png" href="' . static::domain() . 'static/images/database-solid.png">';}

    public static function Home()
    {
        $styles = static::styles() . "Home/";
        $scripts = static::scripts() . "Home/";

        include(__DIR__ . "/../static/pages/Home/index.php");

        return;
    }
    public static function Auth()
    {
        $styles = static::styles() . "Auth/";
        $scripts = static::scripts() . "Auth/";

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

        include(__DIR__ . "/../static/pages/Auth/index.php");

        return $result;
    }
    public static function Account()
    {
        $data = SessionData::$userProfile;

        $styles = static::styles() . "Account/";
        $scripts = static::scripts() . "Account/";

        include(__DIR__ . "/../static/pages/Account/index.php");

        return;
    }
    public static function Cmd()
    {
        $data = SessionData::$userProfile;

        $styles = static::styles() . "Cmd/";
        $scripts = static::scripts() . "Cmd/";

        include(__DIR__ . "/../static/pages/Cmd/index.php");

        return;
    }
}