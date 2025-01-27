<?php
namespace WBlib;

class Settings {
    // |-- SSL --|

    const SSL = true;

    // |-- Errors --|
    const httpErrors = [
        400 => [
            "msg" => true,
            "html" => [
                "file" => "/static/pages/Error/_error.php",
                "code" => 400,
                "h" => "Server Error",
                "msg" => true,
                "redirect" => "/"
            ]
        ],
        403 => [
            "msg" => true,
            "html" => [
                "file" => "/static/pages/Error/_error.php",
                "code" => 404,
                "h" => "Server Error",
                "msg" => true,
                "redirect" => "/"
            ]
        ],
        404 => [
            "msg" => true,
            "html" => [
                "file" => "/static/pages/Error/_error.php",
                "code" => 404,
                "h" => "Server Error",
                "msg" => true,
                "redirect" => "/"
            ]
        ],
        501 => [
            "msg" => true,
            "html" => [
                "file" => "/static/pages/Error/_error.php",
                "code" => 501,
                "h" => "Server Error",
                "msg" => true,
                "redirect" => "/"
            ]
        ],
        503 => [
            "msg" => true,
            "html" => [
                "file" => "/static/pages/Error/_error.php",
                "code" => 503,
                "h" => "Server Error",
                "msg" => true,
                "redirect" => "/"
            ]
        ],
        500 => [
            "msg" => true,
            "html" => [
                "file" => "/static/pages/Error/_error.php",
                "code" => 500,
                "h" => "Server Error",
                "msg" => true,
                "redirect" => "/"
            ]
        ]
    ];

    const apiModeAllowForUrls = [
        0 => "/api"
    ];

    // |-- Error handling sett --|
    const errorVisibility = false;
    const customErrorHandler = true;
    const customErrorHandlerF = 'CustomErrorHandler::customErrorHandler';
    const customFatalErrorHandler = true;
    const customFatalErrorHandlerF = 'CustomErrorHandler::customFatalErrorHandler';

    // |-- Headers --|
    const XpoweredBy = false;

    // |-- Extra Functions --|

    public static function getFullDomain() { return 'https' . "://" . $_SERVER["HTTP_HOST"]; }
    public static function isApiModeAllowed() {
        foreach (Settings::apiModeAllowForUrls as $url) {
            if (str_contains(Settings::getFullDomain() . $_SERVER["REQUEST_URI"], Settings::getFullDomain() . $url)) {
                return true;
            }
        }

        return false;
    }

    // |-- Redis Config --|

    const redisConnectionString = 'redis-18719.c258.us-east-1-4.ec2.redns.redis-cloud.com';
    const redisConnectionNumber = 18719;
    const redisPassword = 'NChjPZd1bToPVm1ZIBE0s9dUXxCaPhep';

    const sysPrefix = '#sys#';
    const userPrefix = '#user#';
    const tokenPrefix = '#token#';
    const profilePrefix = '#profile#';

    // |-- Data Base Gmail --|

    const gmail = 'nonsensdatabase@gmail.com';
    const gmailPass = 'dicr fbsb qhix jnvt';
}
