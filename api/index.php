<?php
include "routes.php";

$url = $_SERVER["REQUEST_URI"];

if ($url == $_HOME) {
    phpinfo();
    include "content/index.php";
    $redis = new Redis();

    $redis->connect("redis-16067.c302.asia-northeast1-1.gce.cloud.redislabs.com", 16067);
    $redis->auth('oT07aeSLCCB8d99gIXxnCYmBhcxaHzl7');

    echo $redis->get("admin");
    
    $redis->close();
} else {
    $_errorCode = 404;
    $_errorH = "Page not found";
    $_errorMsg = "Sorry, we couldn’t find the page you’re looking for.";
    include "_error.php";
}

?>
