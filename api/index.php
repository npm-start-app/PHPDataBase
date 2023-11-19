<?php
include "./routes.php";

$url = $_SERVER["REQUEST_URI"];

if ($url == '/api' . $_HOME) {
    include "./content/index.php";
} else {
    $_errorCode = 404;
    $_errorH = "Page not found";
    $_errorMsg = "Sorry, we couldn’t find the page you’re looking for.";
    include "./_error.php";
}

?>