<?php

use SessionData\SessionData;
use WBlib\Error\Error;
use WBlib\ParamsChecker;
use WBlib\Route;

// 'WBlib\Route::useRedis' -- Open Redis Connection

if (array_key_exists('1', explode('/', $_SERVER['REQUEST_URI']))) {
    if (explode('/', $_SERVER['REQUEST_URI'])[1] === 'static') {
        header((substr(__DIR__ . '/..' . $_SERVER['REQUEST_URI'], -3) === 'css') ? "Content-Type: text/css" : "Content-Type: " . mime_content_type(__DIR__ . '/..' . $_SERVER['REQUEST_URI']));
        echo file_get_contents(__DIR__ . '/..' . $_SERVER['REQUEST_URI']);

        exit();
    } 
}

class Routes
{
    const Home = "/";
    const Auth = "/auth";
    const Account = "/account";
    const Cmd = "/account/cmd";
    const Api_CheckToken = "/api/auth/checkToken";
    const Api_SignIn = "/api/auth/signIn";
    const Api_Auth = "/api/auth";
    const Api_TokenGeneration = "/api/auth/generateToken";
    const Api_Logout = "/api/auth/logout";
    const Api_Login = "/api/auth/login";
    const Api_cmd = "/api/cmd";
    const Api_testRequest = "/api/test";
    const Api_getPass = "/api/auth/getPass";
    const Api_editUserData = "/api/auth/editUserData";
}

class ClientRoutes // All possible client routes
{
    public static function getRoots($route)
    {
        $routes = [
            '/' => [
                'auth' => false,
                'roots' => 0
            ],
            '/auth?login' => [
                'auth' => false,
                'roots' => 0
            ],
            '/auth?reg' => [
                'auth' => false,
                'roots' => 0
            ],
            '/account' => [
                'auth' => true,
                'roots' => 0
            ],
            '/account/cmd' => [
                'auth' => true,
                'roots' => 50
            ]
        ];

        return $routes[$route];
    }
}

# |--- Get Routes ---|

Route::get(Routes::Home, "HtmlController::Home");
Route::get(Routes::Auth, 'WBlib\Route::useRedis', "HtmlController::Auth");
Route::get(
    Routes::Account,
    function () {
        SessionData::$redirectToMain = true;
        AuthChecker::profileIdExistance();
        AuthChecker::tokenExistance();
    },
    'WBlib\Route::useRedis',
    function () {
        AuthChecker::checkAuth();
    },
    "HtmlController::Account"
);
Route::get(
    Routes::Cmd,
    function () {
        SessionData::$redirectToMain = true;
        AuthChecker::profileIdExistance();
        AuthChecker::tokenExistance();
    },
    'WBlib\Route::useRedis',
    function () {
        AuthChecker::checkAuth(50);
    },
    "HtmlController::Cmd"
);

# |--- Api Get Routes ---|

Route::get(
    Routes::Api_getPass,
    function () {
        AuthChecker::profileIdExistance();
    },
    function () {
        AuthChecker::tokenExistance();
    },
    function () {
        $conf = [
            ParamsChecker::HEADERS => ['HTTP_CSRF']
        ];
        ParamsChecker::Existance($conf);
    },
    'WBlib\Route::useRedis',
    function () {
        AuthChecker::checkAuth();
    },
    function () {
        AuthChecker::csrf();
    },
    "AuthController::GetPass"
);
Route::get(
    Routes::Api_Auth,
    function () {
        AuthChecker::profileIdExistance();
    },
    function () {
        AuthChecker::tokenExistance();
    },
    function () {
        $conf = [
            ParamsChecker::DATA => ['route']
        ];
        ParamsChecker::Existance($conf);
    },
    'WBlib\Route::useRedis',
    function () {
        AuthChecker::checkAuth();
    },
    function () {
        $routeSett = ClientRoutes::getRoots($_GET['route']);

        if (SessionData::$user['roots'] < $routeSett['roots']) {
            Error::e403();
        }

        return [
            'status' => true,
            'user' => SessionData::$user
        ];
    }
);
Route::get(
    Routes::Api_Logout,
    function () {
        AuthChecker::profileIdExistance();
    },
    function () {
        AuthChecker::tokenExistance();
    },
    'WBlib\Route::useRedis',
    "AuthController::Logout"
);
Route::get(
    Routes::Api_CheckToken,
    function () {
        $conf = [
            ParamsChecker::DATA => ['token']
        ];
        ParamsChecker::Existance($conf);
    },
    'WBlib\Route::useRedis',
    'AuthController::CheckToken'
);

# |--- Post Routes ---|

# |--- Api Post Routes ---|

Route::post(
    Routes::Api_editUserData,
    function () {
        AuthChecker::profileIdExistance();
    },
    function () {
        AuthChecker::tokenExistance();
    },
    function () {
        $conf = [
            ParamsChecker::DATA => ['login', 'password'],
            ParamsChecker::HEADERS => ['HTTP_CSRF']
        ];
        ParamsChecker::Existance($conf);
    },
    'WBlib\Route::useRedis',
    function () {
        AuthChecker::checkAuth();
    },
    function () {
        AuthChecker::csrf();
    },
    "AuthController::EditUserData"
);
Route::post(
    Routes::Api_cmd,
    function () {
        AuthChecker::profileIdExistance();
    },
    function () {
        AuthChecker::tokenExistance();
    },
    function () {
        $conf = [
            ParamsChecker::DATA => ['command'],
            ParamsChecker::HEADERS => ['HTTP_CSRF']
        ];
        ParamsChecker::Existance($conf);
    },
    'WBlib\Route::useRedis',
    function () {
        AuthChecker::checkAuth(50);
    },
    function () {
        AuthChecker::csrf();
    },
    "Cmd::do"
);
Route::post(
    Routes::Api_Login,
    function () {
        $conf = [
            ParamsChecker::DATA => ['login', 'password']
        ];
        ParamsChecker::Existance($conf);
    },
    'WBlib\Route::useRedis',
    "AuthController::Login"
);
Route::post(
    Routes::Api_SignIn,
    function () {
        AuthChecker::tokenExistance(false, true);
    },
    function () {
        $conf = [
            ParamsChecker::DATA => ['login', 'password']
        ];
        ParamsChecker::Existance($conf);
    },
    'WBlib\Route::useRedis',
    "AuthController::SignIn"
);
Route::post(
    Routes::Api_TokenGeneration,
    function () {
        AuthChecker::profileIdExistance();
    },
    function () {
        AuthChecker::tokenExistance();
    },
    function () {
        $conf = [
            ParamsChecker::DATA => ['token'],
            ParamsChecker::HEADERS => ['HTTP_CSRF']
        ];
        ParamsChecker::Existance($conf);
    },
    'WBlib\Route::useRedis',
    function () {
        AuthChecker::checkAuth(50);
    },
    function () {
        AuthChecker::csrf();
    },
    'AuthController::TokenGeneration'
);
