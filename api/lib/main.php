<?php
namespace WBlib;
$libName = "lib";

include_once('./CustomErrorHandlers/CustomErrorHandler.php');

include_once("./$libName/SessionUserData/sessionUserData.php");
include_once("./$libName/settings.php");
include_once("./$libName/init.php");
include_once("./$libName/Error/error.php");
include_once("./$libName/Error/errorLog.php");
include_once("./$libName/Token/token.php");
include_once("./$libName/Middlewares/index.php");
include_once("./$libName/Redis/index.php");
include_once("./$libName/Mailer/index.php");
include_once("./$libName/Route/route.php");