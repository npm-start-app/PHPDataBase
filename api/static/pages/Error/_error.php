<?php

try {
    if (!isset($_error_code)) {
        die();
    }
    if (!isset($_error_h)) {
        die();
    }
    if (!isset($_error_msg)) {
        die();
    }
    if (!isset($_error_redirect)) {
        die();
    }
} catch (Throwable $__e) {
    die();
} ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <?php echo HtmlController::global_styles(); ?>
    <?php echo HtmlController::icon(); ?>
    <?php echo HtmlController::loader(); ?>
    <link rel="stylesheet" href="<?php echo HtmlController::domain(); ?>static/styles/Error/header.css">
    <link rel="stylesheet" href="<?php echo HtmlController::domain(); ?>static/styles/Error/style.css">
    <?php echo HtmlController::footer(); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Error occured</title>
</head>

<body>
    <div class="navbar">
        <div class="containerH header">
            <a href="/" class="logo">
                <i class="fa-solid fa-database"></i>
                <div>DataBase</div>
            </a>
            <div class="navbarNav">
                <ul id="navbar">
                    <li>
                        <div><a href="<?php echo HtmlController::domain(); ?>#about">About</a></div>
                        <div><a href="<?php echo HtmlController::domain(); ?>#about">About</a></div>
                    </li>
                    <li>
                        <div><a href="<?php echo HtmlController::domain(); ?>">DataBase</a></div>
                        <div><a href="<?php echo HtmlController::domain(); ?>">DataBase</a></div>
                    </li>
                </ul>
                <div class="profile">
                    <a id="user" class="user">
                        <i class="fa-solid fa-user"></i>
                        <div id="userName">Guest</div>
                    </a>
                    <div style="display: none;" id="logoutI" class="logoutI" onclick="logout()">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="main">
        <div class="card">
            <p class="text-base font-semibold text-indigo-600"><?php echo $_error_code ?></p>
            <h1 class="mt-4 text-3xl font-bold tracking-tight text-gray-900 sm:text-5xl"><?php echo $_error_h ?></h1>
            <p class="mt-6 text-base leading-7 text-gray-600"><?php echo $_error_msg ?></p>
            <div class="mt-10 flex items-center justify-center gap-x-6">
                <a href="<?php echo $_error_redirect ?>" class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Main Page</a>
            </div>
        </div>
        <div id="loader" class="loader">
            <div class="sliceL"></div>
            <div class="sliceL"></div>
            <div class="sliceL"></div>
            <div class="sliceL"></div>
            <div class="sliceL"></div>
            <div class="sliceL"></div>
        </div>
    </div>

    <div class="footer"></div>
</body>

</html>