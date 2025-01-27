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
    <?php echo HtmlController::icon() ?>
    <script src="<?php echo HtmlController::localSettings() ?>"></script>
    <script src="<?php echo HtmlController::http() ?>"></script>
    <script src="<?php echo HtmlController::auther() ?>"></script>
    <?php echo HtmlController::global_styles() ?>
    <link rel="stylesheet" href="<?php echo $styles ?>header.css">
    <link rel="stylesheet" href="<?php echo $styles ?>sideHeader.css">
    <link rel="stylesheet" href="<?php echo $styles ?>style.css">
    <?php echo HtmlController::footer() ?>
    <?php echo HtmlController::loader() ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>DataBase</title>
</head>

<body>
    <div id="main" class="mainContent">
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
                    <div class="navbar_a" onclick="sideHeader()"><i class="fa-solid fa-bars"></i></div>
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
                    <div class="hAbout">Hello there! I'm&nbsp;<span>
                            <p id="hobby">Web Developer</p>
                            <p id="nickname">Nons8ns</p>
                        </span></div>
                    <div class="tAbout">Programs' structure is an art. Art for those, who love programming and computers. I hope that one day I will become a master of this art.</div>
                    <a href="https://nextjs-boilerplate-three-blond-44.vercel.app" class="aAbout aAbout_o">See my About website</a>
                </div>
                <img src="<?php echo HtmlController::domain() ?>static/images/about_4.svg" />
                <a href="https://nextjs-boilerplate-three-blond-44.vercel.app" class="aAbout aAbout_n">See my About website</a>
            </div>
        </div>

        <div class="dataBase">
            <div></div>
        </div>

        <div class="footer"></div>
    </div>

    <div class="sideHeader" id="sideHeader">
        <div class="side_header">
            <div class="side_header_h">Navigation</div>
            <div class="side_header_x"><i onclick="closeSideHeader()" class="fa-solid fa-x"></i></div>
        </div>
        <ul id="side_navbar" class="side_navbar">
            <li>
                <div><a href="<?php echo HtmlController::domain(); ?>#about">About</a></div>
            </li>
            <li>
                <div><a href="<?php echo HtmlController::domain(); ?>">DataBase</a></div>
            </li>
        </ul>
    </div>

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
