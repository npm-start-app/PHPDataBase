<?php

use SessionData\SessionData;
use WBlib\Token;

try {
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
    <?php echo HtmlController::global_styles() ?>
    <link rel="stylesheet" href="<?php echo $styles ?>style.css">
    <link rel="stylesheet" href="<?php echo $styles ?>cmd.css">
    <link rel="stylesheet" href="<?php echo $styles ?>explorer.css">
    <link rel="stylesheet" href="<?php echo $styles ?>header.css">
    <?php echo HtmlController::footer() ?>
    <?php echo HtmlController::loader() ?>
    <script src="https://kit.fontawesome.com/e69856d59d.js" crossorigin="anonymous"></script>
    <title>Cmd</title>
</head>

<body>
    <input onchange="_doSubFunc()" id='inputFile' type="file" style="display: none;" />
    <input id="csrf" style="display: none;" disabled hidden readonly value="<?php echo $data['csrf']; ?>" />

    <div class="navbar">
        <div class="container header">
            <a href="/" class="logo">
                <i class="fa-solid fa-database"></i>
                <div>DataBase</div>
            </a>
            <div class="navbarNav">
                <ul id="navbar">
                    <li>
                        <div><a href="<?php echo HtmlController::domain(); ?>account#files">Your files</a></div>
                        <div><a href="<?php echo HtmlController::domain(); ?>account#files">Your files</a></div>
                    </li>
                    <li>
                        <div><a href="<?php echo HtmlController::domain(); ?>">DataBase</a></div>
                        <div><a href="<?php echo HtmlController::domain(); ?>">DataBase</a></div>
                    </li>
                    <li>
                        <div><a href="<?php echo HtmlController::domain(); ?>account">Account data</a></div>
                        <div><a href="<?php echo HtmlController::domain(); ?>account">Account data</a></div>
                    </li>
                    <li>
                        <div><a href="<?php echo HtmlController::domain() ?>account/cmd">Cmd</a></div>
                        <div><a href="<?php echo HtmlController::domain() ?>account/cmd">Cmd</a></div>
                    </li>
                </ul>
                <div class="profile">
                    <a href="/account" id="user" class="user">
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

    <div class="tools">
        <div class="explorer">
            <div class="EPh">Google Drive Explorer</div>
            <div id="explorer" class="EPm"></div>
        </div>
        <div class="cmdC">
            <div class="cmd_"><img width="36" height="36"
                    src="<?php echo HtmlController::domain() ?>static/images/cmd.png" />DataBase://account/cmd</div>
            <div id="cmd" class="cmd"></div>
        </div>
        <div id="path" class="path">
            <div mime="application/vnd.google-apps.folder" onclick="path_onclick(this)" id="root" class="_Spath">
                DataBase - root
            </div>
        </div>
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
    <script src="<?php echo $scripts ?>cmd.js"></script>
    <script src="<?php echo $scripts ?>explorer.js"></script>
</body>

</html>