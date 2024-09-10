<?php try {
    HtmlController::global_styles();
    HtmlController::http();
    HtmlController::domain();
    HtmlController::auther();
    HtmlController::localSettings();
    if (!isset($scripts)) {
        die();
    }
    if (!isset($_GET)) {
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="<?php echo HtmlController::localSettings() ?>"></script>
    <script src="<?php echo HtmlController::http() ?>"></script>
    <?php echo HtmlController::global_styles() ?>
    <link rel="stylesheet" href="<?php echo $styles ?>style.css">
    <link rel="stylesheet" href="<?php echo $styles ?>header.css">
    <title>Document</title>
</head>

<body>
    <div class="loginbackground box-background--white padding-top--64">
        <div class="loginbackground-gridContainer">
            <div class="box-root flex-flex" style="grid-area: top / start / 8 / end;">
                <div class="box-root"
                    style="background-image: linear-gradient(#0c0c0d 0%, #151516 33%); flex-grow: 1;">
                </div>
            </div>
            <div class="box-root flex-flex" style="grid-area: 4 / 2 / auto / 5;">
                <div class="box-root box-divider--light-all-2 animationLeftRight tans3s" style="flex-grow: 1;">
                </div>
            </div>
            <div class="box-root flex-flex" style="grid-area: 6 / start / auto / 2;">
                <div class="box-root box-background--blue800" style="flex-grow: 1;"></div>
            </div>
            <div class="box-root flex-flex" style="grid-area: 7 / start / auto / 4;">
                <div id="yellowBox1" class="box-root box-background--blue animationLeftRight" style="flex-grow: 1;"></div>
            </div>
            <div class="box-root flex-flex" style="grid-area: 8 / 4 / auto / 6;">
                <div class="box-root box-background--gray100 animationLeftRight tans3s" style="flex-grow: 1;">
                </div>
            </div>
            <div class="box-root flex-flex" style="grid-area: 2 / 15 / auto / end;">
                <div class="box-root box-background--cyan200 animationRightLeft tans4s" style="flex-grow: 1;">
                </div>
            </div>
            <div class="box-root flex-flex" style="grid-area: 3 / 14 / auto / end;">
                <div id="yellowBox2" class="box-root box-background--blue animationRightLeft" style="flex-grow: 1;"></div>
            </div>
            <div class="box-root flex-flex" style="grid-area: 4 / 17 / auto / 20;">
                <div class="box-root box-background--gray100 animationRightLeft tans4s" style="flex-grow: 1;">
                </div>
            </div>
            <div class="box-root flex-flex" style="grid-area: 5 / 14 / auto / 17;">
                <div class="box-root box-divider--light-all-2 animationRightLeft tans3s" style="flex-grow: 1;">
                </div>
            </div>
        </div>
    </div>

    <div class="navbar">
        <div class="container header">
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
                    <li>
                        <div><a href="<?php echo HtmlController::domain(); ?>auth?login">Log in</a></div>
                        <div><a href="<?php echo HtmlController::domain(); ?>auth?login">Log in</a></div>
                    </li>
                    <li>
                        <div><a href="<?php echo HtmlController::domain(); ?>auth?reg">Sign in</a></div>
                        <div><a href="<?php echo HtmlController::domain(); ?>auth?reg">Sign in</a></div>
                    </li>
                </ul>
            </div>
            <a class="logo" id="logo">
                <i class="fa-solid fa-database"></i>
                <div>DataBase</div>
            </a>
        </div>
    </div>

    <div class="main">
        <div class="form">
            <div class="hFText">
                <?php if (array_key_exists("reg", $_GET)) {
                    echo "Sign up for DataBase";
                } else {
                    echo "Log in to your account";
                } ?>
            </div>
            <div id="inputs" class="inputs">
                <?php if (array_key_exists("reg", $_GET)): ?>
                    <div class="input">
                        <label for="token">Token</label>
                        <input type="text" id="token" name="token" required />
                    </div>
                <?php else: ?>
                    <div class="input">
                        <label for="username">Username</label>
                        <input type="text" id="login" name="username" required />
                    </div>
                    <div class="input">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required />
                    </div>
                <?php endif; ?>
            </div>
            <div class="button">
                <button id="button" onclick="<?php if (array_key_exists("reg", $_GET)) {
                                                    echo "checkTheAuthToken()";
                                                } else {
                                                    echo "dataValidationLogin()";
                                                } ?>">Check</button>
            </div>

            <div style="display: none;" id="back" class="button">
                <button onclick="tokenForm()">Back</button>
            </div>

            <div id="errorMSG"></div>

            <?php if (array_key_exists("reg", $_GET)): ?>
                <div class="signUpRef">Have already an account?
                    <a href="?login">Log in</a>
                </div>
            <?php else: ?>
                <div class="signUpRef">Don't have an account?
                    <a href="?reg">Sign up</a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div id="Icons" class="stopAnim"></div>

    <script src="<?php echo $scripts ?>main.js"></script>
</body>

</html>