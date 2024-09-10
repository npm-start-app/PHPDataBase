<?php 
namespace WBlib\ErrorLog;

interface ErrorLog {
    public static function errorHandler($errno, $errstr, $errfile, $errline);
    public static function fatalErrorHandler();
}