<?php
namespace WBlib;
$libName = "lib";

include_once(__DIR__ . '/CustomErrorHandlers/CustomErrorHandler.php');

include_once(__DIR__ . "/$libName/SessionUserData/sessionUserData.php");
include_once(__DIR__ . "/$libName/settings.php");
include_once(__DIR__ . "/$libName/init.php");
include_once(__DIR__ . "/$libName/Error/error.php");
include_once(__DIR__ . "/$libName/Error/errorLog.php");
include_once(__DIR__ . "/$libName/Token/token.php");
include_once(__DIR__ . "/$libName/Middlewares/index.php");
include_once(__DIR__ . "/$libName/Redis/index.php");
include_once(__DIR__ . "/$libName/Mailer/index.php");
include_once(__DIR__ . "/$libName/Route/route.php");
