<?php

use SessionData\SessionData;
use WBlib\Route;

class CustomErrorHandler
{
    public static function customErrorHandler($errno, $errstr, $errfile, $errline)
    {
        if (SessionData::$set_error_handler) {
            Route::response(
                [
                    'status' => false,
                    'message' => $errstr,
                    'error' => $errline,
                    'file' => $errfile
                ],
                500
            );
        }

        return false;
    }
    public static function customFatalErrorHandler()
    {
        $error = error_get_last();
        if ($error !== null && $error['type'] === E_ERROR) {
            Route::response(
                [
                    'status' => false,
                    'message' => $error['message']
                ],
                500
            );
        }
    }
}
