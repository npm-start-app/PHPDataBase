<?php
use WBlib\Route;

include_once ("./var/task/user/api/lib/main.php");
include_once ("./Roles/roles.php");
include_once ("./Middlewares/main.php");
include_once ("./Controllers/main.php");
include_once ("./Routes/routes.php");

Route::route();
