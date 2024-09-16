<?php

use WBlib\Error\Error;
use WBlib\Route;
use SessionData\SessionData;
use WBlib\Settings;

class AuthChecker
{
    private static function check($profileId, $roots)
    {
        $result = RD::getValue($profileId, Settings::profilePrefix, true);

        if (!$result) {
            if (SessionData::$redirectToMain) {
                header('Location: ' . Settings::getFullDomain());

                die();
            }

            Route::response([
                "status" => false,
                "message" => "Auth was failed."
            ], Error::BadRequest);

            return false;
        }
        $result = json_decode($result, true);

        $token = SessionData::$token;

        $salt = explode('#', $result['accessToken'])[0];

        $newAccessToken = $salt . "#" . $token;
        if (strcmp($newAccessToken, $result['accessToken']) !== 0) {
            if (SessionData::$redirectToMain) {
                header('Location: ' . Settings::getFullDomain());

                die();
            }

            Route::response([
                "status" => false,
                "message" => "Auth was failed."
            ], Error::BadRequest);
        }

        $salt = json_decode($salt, true);

        if ($salt['roots'] < $roots) {
            if (SessionData::$redirectToMain) {
                header('Location: ' . Settings::getFullDomain());

                die();
            }

            Route::response([
                "status" => false,
                "message" => "Auth was failed."
            ], Error::Forbidden);

            return false;
        }

        SessionData::$user = [
            'login' => $salt['login'],
            'role' => $salt['role'],
            'roots' => $salt['roots'],
            'csrfSecret' => $result['csrfSecret']
        ];

        SessionData::$userProfile = $result;

        return true;
    }

    public static function checkAuth($roots = 0)
    {
        $profileId = SessionData::$profileId;

        AuthChecker::check($profileId, $roots);
    }

    public static function tokenExistance($cookie = true, $localStorage = false)
    {
        if ($cookie) {
            if (!array_key_exists('token', $_COOKIE)) {
                if (SessionData::$redirectToMain) {
                    header('Location: ' . Settings::getFullDomain());

                    die();
                }

                Route::response([
                    "status" => false,
                    "message" => "Bad parameters."
                ], Error::BadRequest);
            }

            SessionData::$token = trim($_COOKIE['token']);

            return true;
        }

        if ($localStorage) {
            if (!array_key_exists('HTTP_TOKEN', $_SERVER)) {
                if (SessionData::$redirectToMain) {
                    header('Location: ' . Settings::getFullDomain());

                    die();
                }

                Route::response([
                    "status" => false,
                    "message" => "Bad parameters."
                ], Error::BadRequest);
            }

            SessionData::$token = trim($_SERVER['HTTP_TOKEN']);
        }
    }

    public static function profileIdExistance()
    {
        if (!array_key_exists('profileId', $_COOKIE)) {
            if (!array_key_exists('HTTP_PROFILEID', $_SERVER)) {
                if (SessionData::$redirectToMain) {
                    header('Location: ' . Settings::getFullDomain());

                    die();
                }

                Route::response([
                    "status" => false,
                    "message" => "Bad parameters."
                ], Error::BadRequest);
            }

            SessionData::$profileId = trim($_SERVER['HTTP_PROFILEID']);

            return true;
        }

        SessionData::$profileId = trim($_COOKIE['profileId']);
    }

    public static function csrf()
    {
        $csrf = $_SERVER['HTTP_CSRF'];
        $salt = explode(':', $csrf)[0];

        $newCsrf = $salt . ":" . md5($salt . ":" . SessionData::$user['csrfSecret']);

        if (strcmp($newCsrf, $csrf) !== 0) {
            Route::response([
                "status" => false,
                "message" => "Bad parameters."
            ], Error::BadRequest);
        }

        if (strcmp(SessionData::$userProfile['csrf'], $csrf) !== 0) {
            Route::response([
                "status" => false,
                "message" => "Bad parameters."
            ], Error::BadRequest);
        }
    }
}
