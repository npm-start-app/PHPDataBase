<?php
use WBlib\Route;

$_dir_ = __DIR__;

include_once ($_dir_ . "/lib/main.php");
include_once ($_dir_ . "/Roles/roles.php");
include_once ($_dir_ . "/Middlewares/main.php");
include_once ($_dir_ . "/Controllers/main.php");
include_once ($_dir_ . "/Routes/routes.php");

Route::route();
