<?php try {
    HtmlController::global_styles();
    HtmlController::http();
    HtmlController::domain();
    HtmlController::auther();
    HtmlController::localSettings();
    HtmlController::footer();
    HtmlController::loader();
    if (!isset($scripts)) {
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
    <script src="<?php echo HtmlController::localSettings() ?>"></script>
    <script src="<?php echo HtmlController::http() ?>"></script>
    <script src="<?php echo HtmlController::auther() ?>"></script>
    <?php echo HtmlController::global_styles() ?>
    <link rel="stylesheet" href="<?php echo $styles ?>header.css">
    <link rel="stylesheet" href="<?php echo $styles ?>style.css">
    <?php echo HtmlController::footer() ?>
    <?php echo HtmlController::loader() ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>DataBase</title>
</head>

<body>
    <div class="navbar">
        <div class="container header">
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

    <div class="about">
        <div class="container aboutC">
            <div class="contentAbout">
                <div class="hAbout">Hello there! I'm <span>
                        <p id="nickname">Nons8ns</p>
                        <p id="hobby">Web Developer</p>
                    </span></div>
                <div class="tAbout">Programs' structure is an art. Art for those, who love programming and computers. I hope that one day I will become a master of this art.</div>
                <a href="https://nextjs-boilerplate-three-blond-44.vercel.app" class="aAbout">See my About website</a>
            </div>
            <img src="<?php echo HtmlController::domain() ?>static/images/about_4.svg" />
        </div>
    </div>

    <div class="dataBase">
        <div></div>
    </div>

    <div class="footer"></div>

    <div id="Icons" class="icons">
        <div style="display: none;" id="loader" class="loader">
            <div class="sliceL"></div>
            <div class="sliceL"></div>
            <div class="sliceL"></div>
            <div class="sliceL"></div>
            <div class="sliceL"></div>
            <div class="sliceL"></div>
        </div>
    </div>

    <script src="<?php echo $scripts ?>main.js"></script>
</body>

</html>