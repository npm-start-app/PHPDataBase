<?php
use WBlib\Route;

include_once (__DIR__ . "/lib/main.php");
include_once (__DIR__ . "/Roles/roles.php");
include_once (__DIR__ . "/Middlewares/main.php");
include_once (__DIR__ . "/Controllers/main.php");
include_once (__DIR__ . "/Routes/routes.php");

Route::route();