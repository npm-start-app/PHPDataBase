<?php

use SessionData\SessionData;
use WBlib\Token;

try {
    HtmlController::global_styles;
    HtmlController::http;
    HtmlController::domain;
    HtmlController::auther;
    HtmlController::localSettings;
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
    <script src="<?php echo HtmlController::localSettings ?>"></script>
    <script src="<?php echo HtmlController::http ?>"></script>
    <?php echo HtmlController::global_styles ?>
    <link rel="stylesheet" href="<?php echo $styles ?>style.css">
    <link rel="stylesheet" href="<?php echo $styles ?>header.css">
    <script src="https://kit.fontawesome.com/e69856d59d.js" crossorigin="anonymous"></script>
    <title>DataBase Account</title>
</head>

<body>
    <input id="csrf" style="display: none;" disabled hidden readonly value="<?php echo Token::csrf(SessionData::$user['csrfSecret']); ?>" />

    <div class="navbar">
        <div class="container header">
            <a href="/" class="logo">
                <i class="fa-solid fa-database"></i>
                <div>DataBase</div>
            </a>
            <div class="navbarNav">
                <ul id="navbar">
                    <li>
                        <div><a href="<?php echo HtmlController::domain; ?>account#files">Your files</a></div>
                        <div><a href="<?php echo HtmlController::domain; ?>account#files">Your files</a></div>
                    </li>
                    <li>
                        <div><a href="<?php echo HtmlController::domain; ?>">DataBase</a></div>
                        <div><a href="<?php echo HtmlController::domain; ?>">DataBase</a></div>
                    </li>
                    <li>
                        <div><a href="<?php echo HtmlController::domain; ?>account">Account data</a></div>
                        <div><a href="<?php echo HtmlController::domain; ?>account">Account data</a></div>
                    </li>
                    <?php if (SessionData::$user['roots']): ?>

                        <li>
                            <div><a href="<?php echo HtmlController::domain ?>account/cmd">Cmd</a></div>
                            <div><a href="<?php echo HtmlController::domain ?>account/cmd">Cmd</a></div>
                        </li>

                    <?php endif; ?>
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

    <div class="profileInfo">
        <div class="h">
            Account Information
        </div>
        <div class="profileA">
            <div class="icon">
                <i class="fa-solid fa-user"></i>
            </div>
            <div class="info">
                <div class="input">
                    <label for="username">Username</label>
                    <input id="login" type="text" name="username" />
                </div>
                <div class="input">
                    <label for="password">Password</label>
                    <div style="display: flex; flex-direction: row; align-items: center; gap: 20px;">
                        <input id="password" type="password" name="password" />
                        <i id="locker" onclick="showPass()" style="font-size: 25px; cursor: pointer;" class="fa-solid fa-lock"></i>
                    </div>
                </div>
                <div class="input">
                    <label for="role">Role</label>
                    <input id="role" type="text" name="role" readonly />
                </div>
            </div>
        </div>
        <div class="profileButtons">
            <button onclick="returnData()">Return</button>
            <button onclick="editUserData()">Save</button>
        </div>
    </div>

    <?php if (SessionData::$user['roots'] >= 50): ?>

        <div id="TG" class="tokenG">
            <div class="h">
                Token Generation
            </div>

            <div class="tokenGC">
                <select id="selectToken">
                    <option value="" selected disabled hidden>Choose Token</option>
                    <?php if(SessionData::$user['roots'] === 100): ?>
                        <option value="Admin Token">Admin Token</option>
                        <option value="Trustful User Token">Trustful User Token</option>
                    <?php endif; ?>
                    <option value="User Token">User Token</option>
                </select>
                <button onclick="generateToken()">Generate</button>
            </div>
        </div>

    <?php endif; ?>

    <div class="footer"></div>

    <script src="<?php echo $scripts ?>main.js"></script>
</body>

</html>