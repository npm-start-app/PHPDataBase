<?php

use SessionData\SessionData;
use WBlib\Error\Error;
use WBlib\Route;
use WBlib\Mailer;
use WBlib\Settings;
use WBlib\Token;

class AuthController
{
    public static function Init()
    {
        try {
            $result = RD::getValue('Init', Settings::sysPrefix, true);

            if (!$result or !json_decode($result, true)['status']) {
                RD::setValue('AdminGeneratedToken', json_encode([
                    "status" => false
                ]), Settings::sysPrefix);

                RD::setValue('Init', json_encode([
                    "status" => true
                ]), Settings::sysPrefix);
            }

            return [
                "status" => true
            ];
        } catch (Throwable $e) {
            

            Error::e500();
        }
    }
    public static function getAdminGeneratedToken()
    {
        try {
            $result = RD::getValue('AdminGeneratedToken', Settings::sysPrefix);

            $mail = Mailer::create();

            $mail->Priority = 1;
            $mail->addAddress('nonsensdatabase@gmail.com');
            $mail->From = 'nonsensdatabase@gmail.com';
            $mail->FromName = 'DataBase Mailer';
            $mail->isHTML(true);
            $mail->Subject = 'Receiving the Token';
            $mail->Body = '<strong>Hey!</strong> Here is your access admin token [<strong>' . json_decode($result, true)['token'] . '</strong>].';

            if (!$mail->send()) {
                echo 'Message could not be sent.';
            } else {
                echo 'Message has been sent';
            }
        } catch (Throwable $th) {
            Error::e500();
        }
    }
    public static function GenerateAdminToken()
    {
        try {
            function generate()
            {
                $token = Token::token(Token::SHA512);

                RD::setValue($token, json_encode(['role' => Roles::ADMIN]), Settings::tokenPrefix);

                RD::setValue('AdminGeneratedToken', json_encode([
                    "status" => true,
                    "token" => $token
                ]), Settings::sysPrefix);

                $mail = Mailer::create();

                $mail->Priority = 1;
                $mail->addAddress('nonsensdatabase@gmail.com');
                $mail->From = 'nonsensdatabase@gmail.com';
                $mail->FromName = 'DataBase Mailer';
                $mail->isHTML(true);
                $mail->Subject = 'Receiving the Token';
                $mail->Body = '<strong>Hey!</strong> Here is your access Admin Token [ <strong>' . $token . '</strong> ].';

                if (!$mail->send()) {
                    echo 'Message could not be sent.';
                } else {
                    echo 'Message has been sent';
                }
            }

            $result = RD::getValue('AdminGeneratedToken', Settings::sysPrefix);
            if ($result) {
                if (!json_decode($result, true)['status']) {
                    generate();
                } else {
                    echo 'New token can not be generated.';
                }
            } else {
                echo "Init error";
            }

            
        } catch (Throwable $th) {
            Error::e500();
        }
    }
    public static function CheckToken()
    {
        $token = $_GET['token'];

        $result = RD::getValue($token, Settings::tokenPrefix, true);

        if (!$result) {
            Route::response(
                [
                    "status" => false
                ],
                Error::BadRequest
            );
        }

        if (array_key_exists('authUsage', json_decode($result, true))) {
            Route::response(
                [
                    "status" => false
                ],
                Error::BadRequest
            );
        }

        return [
            "status" => true,
            "role" => json_decode($result, true)["role"],
            "roots" => Roles::role(json_decode($result, true)["role"])
        ];
    }
    public static function SignIn()
    {
        $token = SessionData::$token;
        $login = trim($_POST['login']);
        $password = trim($_POST['password']);

        $result = RD::getValue($token, Settings::tokenPrefix, true);
        $role = json_decode($result, true)['role'];

        if (!$result) {
            Route::response([
                "status" => false,
                "message" => 'Incorrect token.'
            ], Error::BadRequest);
        }
        if (array_key_exists('authUsage', json_decode($result, true))) {
            Route::response([
                "status" => false,
                "message" => 'Incorrect token.'
            ], Error::BadRequest);
        }

        $checkLogin = static::checkLogin($_POST['login']);
        if (!$checkLogin['status']) {
            Route::response([
                "status" => false,
                "message" => $checkLogin['message']
            ], Error::BadRequest);
        }

        $checkPassword = static::checkPassword($_POST['password']);
        if (!$checkPassword['status']) {
            Route::response([
                "status" => false,
                "message" => $checkPassword['message']
            ], Error::BadRequest);
        }

        $profileId = Token::token(Token::MD5);
        RD::setValue($login, json_encode([
            "role" => $role,
            "password" => $password,
            "roots" => Roles::role($role),
            "profileId" => $profileId
        ]), Settings::userPrefix);

        RD::deleteValue($token, Settings::tokenPrefix);

        $accessTokenSecret = Token::token(Token::SHA512);
        $newToken = Token::accessToken($login, $role, Roles::role($role), $accessTokenSecret);
        $csrfSecret = Token::token(Token::SHA512);
        $driveToken = Token::token(Token::MD5);
        RD::setValue($profileId, json_encode([
            'csrf' => Token::csrf($csrfSecret),
            'accessToken' => $newToken,
            'csrfSecret' => $csrfSecret,
            'accessTokenSecret' => $accessTokenSecret,
            'driveToken' => $driveToken
        ]), Settings::profilePrefix);

        $user = [
            'login' => $login,
            'role' => $role,
            'roots' => Roles::role($role)
        ];

        setcookie('profileId', $profileId, time() + (3600), '/', '', false, true);
        setcookie('token', explode('#', $newToken)[1], time() + (3600), '/', '', false, true);

        return [
            "status" => true,
            "user" => $user
        ];
    }
    public static function Logout()
    {
        $profileId = SessionData::$profileId;

        $result = RD::getValue($profileId, Settings::profilePrefix, true);

        if (!$result) {
            Route::response([
                "status" => false,
                "message" => 'Incorrect profileId.'
            ], Error::BadRequest);
        }

        setcookie('profileId', '', -1, '/');
        setcookie('token', '', -1, '/');

        return [
            'status' => true
        ];
    }
    public static function Login()
    {
        $login = trim($_POST['login']);
        $password = trim($_POST['password']);

        $result = RD::getValue($login, Settings::userPrefix, true);

        if (!$result) {
            Route::response([
                "status" => false,
                "message" => 'Login was failed.'
            ], Error::BadRequest);
        }

        if ($password !== json_decode($result, true)['password']) {
            Route::response([
                "status" => false,
                "message" => 'Login was failed.'
            ], Error::BadRequest);
        }

        $result = json_decode($result, true);
        $profileId = $result['profileId'];

        $accessTokenSecret = Token::token(Token::SHA512);
        $newToken = Token::accessToken($login, $result['role'], $result['roots'], $accessTokenSecret);
        $csrfSecret = Token::token(Token::SHA512);
        $driveToken = Token::token(Token::MD5);
        RD::setValue($profileId, json_encode([
            'csrf' => Token::csrf($csrfSecret),
            'accessToken' => $newToken,
            'csrfSecret' => $csrfSecret,
            'accessTokenSecret' => $accessTokenSecret,
            'driveToken' => $driveToken
        ]), Settings::profilePrefix);

        setcookie('profileId', $profileId, time() + (3600), '/', '', false, true);
        setcookie('token', explode('#', $newToken)[1], time() + (3600), '/', '', false, true);

        $user = [
            'login' => $login,
            'role' => $result['role'],
            'roots' => $result['roots']
        ];

        return [
            "status" => true,
            "user" => $user
        ];
    }
    public static function TokenGeneration()
    {
        if (Roles::tokenGenerationRoots($_POST['token'], SessionData::$user['roots'])) {
            $token = Token::token(Token::SHA512);

            RD::setValue($token, json_encode(['role' => Roles::getTokenGenerationRole($_POST['token'])]), Settings::tokenPrefix);

            $mail = Mailer::create();

            $mail->Priority = 1;
            $mail->addAddress('nonsensdatabase@gmail.com');
            $mail->From = 'nonsensdatabase@gmail.com';
            $mail->FromName = 'DataBase Mailer';
            $mail->isHTML(true);
            $mail->Subject = 'Receiving the Token';
            $mail->Body = '<strong>Hey!</strong> Here is your access ' . $_POST['token'] . ' [ <strong>' . $token . '</strong> ].';

            $msg = '';

            if (!$mail->send()) {
                $msg = 'Message could not be sent. But code was created';
            } else {
                $msg = 'Message has been sent';
            }

            return [
                "status" => true,
                "message" => $msg
            ];
        }

        Error::e403();
    }

    public static function GetPass()
    {
        $result = RD::getValue(SessionData::$user['login'], Settings::userPrefix, true);

        return [
            'status' => true,
            'password' => json_decode($result, true)['password']
        ];
    }

    private static function checkLogin($login)
    {
        if (strlen($login) <= 2) {
            return [
                'status' => false,
                'message' => 'Login is too short.'
            ];
        }
        if (strlen($login) >= 40) {
            return [
                'status' => false,
                'message' => 'Login is too long.'
            ];
        }
        if ($login != strip_tags($login)) {
            return [
                'status' => false,
                'message' => 'Login contains invalid data.'
            ];
        }
        if (RD::getValue($login, Settings::userPrefix, true)) {
            return [
                'status' => false,
                'message' => 'Login is in usage already.'
            ];
        }

        return [
            'status' => true
        ];
    }

    private static function checkPassword($password)
    {
        if (strlen($password) <= 5) {
            return [
                'status' => false,
                'message' => 'Password is too short.'
            ];
        }
        if (strlen($password) >= 40) {
            return [
                'status' => false,
                'message' => 'Password is too long.'
            ];
        }
        if ($password != strip_tags($password)) {
            return [
                'status' => false,
                'message' => 'Password contains invalid data.'
            ];
        }

        return [
            'status' => true
        ];
    }

    public static function EditUserData()
    {
        if ($_POST['login'] and $_POST['password']) {
            $checkLogin = static::checkLogin($_POST['login']);
            if (!$checkLogin['status']) {
                Route::response([
                    "status" => false,
                    "message" => $checkLogin['message']
                ], Error::BadRequest);
            }

            $checkPassword = static::checkPassword($_POST['password']);
            if (!$checkPassword['status']) {
                Route::response([
                    "status" => false,
                    "message" => $checkPassword['message']
                ], Error::BadRequest);
            }

            $oldUser = RD::getValue(SessionData::$user['login'], Settings::userPrefix, true);
            if (!$oldUser) {
                Route::response(["status" => false, "message" => 'Unexpected error.'], Error::InternalServerError);
            }
            $oldUser = json_decode($oldUser, true);
            $oldUser['password'] = $_POST['password'];
            $oldUser = json_encode($oldUser);

            RD::deleteValue(SessionData::$user['login'], Settings::userPrefix);

            RD::setValue($_POST['login'], $oldUser, Settings::userPrefix);

            $oldProfile = RD::getValue(json_decode($oldUser, true)['profileId'], Settings::profilePrefix, true);
            if (!$oldProfile) {
                Route::response(["status" => false, "message" => 'Unexpected error.'], Error::InternalServerError);
            }
            $oldProfile = json_decode($oldProfile, true);
            $newToken = Token::accessToken($_POST['login'], json_decode($oldUser, true)['role'], json_decode($oldUser, true)['roots'], $oldProfile['accessTokenSecret']);
            $oldProfile['accessToken'] = $newToken;
            $oldProfile = json_encode($oldProfile);

            RD::setValue(json_decode($oldUser, true)['profileId'], $oldProfile, Settings::profilePrefix);

            setcookie('token', explode('#', $newToken)[1], time() + (3600), '/', '', false, true);

            $user = [
                'login' => $_POST['login'],
                'role' => json_decode($oldUser, true)['role'],
                'roots' => json_decode($oldUser, true)['roots']
            ];
        } else if ($_POST['password']) {
            $checkPassword = static::checkPassword($_POST['password']);
            if (!$checkPassword['status']) {
                Route::response([
                    "status" => false,
                    "message" => $checkPassword['message']
                ], Error::BadRequest);
            }

            $oldUser = RD::getValue(SessionData::$user['login'], Settings::userPrefix, true);
            if (!$oldUser) {
                Route::response(["status" => false, "message" => 'Unexpected error.'], Error::InternalServerError);
            }
            $oldUser = json_decode($oldUser, true);
            $oldUser['password'] = $_POST['password'];
            $oldUser = json_encode($oldUser);

            RD::deleteValue(SessionData::$user['login'], Settings::userPrefix);

            RD::setValue(SessionData::$user['login'], $oldUser, Settings::userPrefix);

            $user = [
                'login' => SessionData::$user['login'],
                'role' => json_decode($oldUser, true)['role'],
                'roots' => json_decode($oldUser, true)['roots']
            ];
        } else {
            $checkLogin = static::checkLogin($_POST['login']);
            if (!$checkLogin['status']) {
                Route::response([
                    "status" => false,
                    "message" => $checkLogin['message']
                ], Error::BadRequest);
            }

            $oldUser = RD::getValue(SessionData::$user['login'], Settings::userPrefix, true);
            if (!$oldUser) {
                Route::response(["status" => false, "message" => 'Unexpected error.'], Error::InternalServerError);
            }

            RD::deleteValue(SessionData::$user['login'], Settings::userPrefix);

            RD::setValue($_POST['login'], $oldUser, Settings::userPrefix);

            $oldProfile = RD::getValue(json_decode($oldUser, true)['profileId'], Settings::profilePrefix, true);
            if (!$oldProfile) {
                Route::response(["status" => false, "message" => 'Unexpected error.'], Error::InternalServerError);
            }
            $oldProfile = json_decode($oldProfile, true);
            $newToken = Token::accessToken($_POST['login'], json_decode($oldUser, true)['role'], json_decode($oldUser, true)['roots'], $oldProfile['accessTokenSecret']);
            $oldProfile['accessToken'] = $newToken;
            $oldProfile = json_encode($oldProfile);

            RD::setValue(json_decode($oldUser, true)['profileId'], $oldProfile, Settings::profilePrefix);

            setcookie('token', explode('#', $newToken)[1], time() + (3600), '/', '', false, true);

            $user = [
                'login' => $_POST['login'],
                'role' => json_decode($oldUser, true)['role'],
                'roots' => json_decode($oldUser, true)['roots']
            ];
        }

        return [
            'status' => true,
            'user' => $user
        ];
    }

    public static function getDriveToken () {
        $driveToken = SessionData::$userProfile['driveToken'];
        
        return [
            'status' => true,
            'driveToken' => $driveToken,
            'profileId' => SessionData::$profileId
        ];
    }
}
