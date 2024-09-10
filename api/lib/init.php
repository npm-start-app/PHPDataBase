<?php
namespace WBlib;

use CustomErrorHandler;

class Init
{
    public static function errorLog()
    {
        ini_set('display_errors', Settings::errorVisibility);
        ini_set('display_startup_errors', Settings::errorVisibility);
        error_reporting(E_ALL);
    }
    public static function errorHandler() {
        if (Settings::customErrorHandler){
            set_error_handler(Settings::customErrorHandlerF);
        }
    }
    public static function fatalErrorHandler() {
        if (Settings::customFatalErrorHandler) {
            register_shutdown_function(Settings::customFatalErrorHandlerF);
        }
    }
    public static function headers() {
        if (!Settings::XpoweredBy) {
            header_remove('x-powered-by');
        }
    }
}

Init::errorLog();
Init::errorHandler();
Init::fatalErrorHandler();
Init::headers();