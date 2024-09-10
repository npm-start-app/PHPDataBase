<?php
namespace WBlib;

class Token {
    const MD5 = "$1$";
    const SHA256 = "$5$";
    const SHA512 = "$6$";

    public static function token($type, $tokenKey = "") {
        return str_replace(
            "$",
            bin2hex(random_bytes(30)),
            md5(random_bytes(30) . $tokenKey) . substr(
                CRYPT(time() . bin2hex(random_bytes(30)) . "$" . $tokenKey, "$type" . bin2hex(random_bytes(30)) . time() . "$"),
                3
            )
        );
    }

    public static function csrf($secret_) {
        $salt = static::token(static::MD5);
        $secret = $secret_;

        return $salt . ":" . md5($salt . ":" . $secret);
    }

    public static function accessToken($login, $role, $roots, $secret_) {
        $salt = json_encode([
            "login" => $login,
            "role" => $role,
            "roots" => $roots
        ]);
        $secret = $secret_;

        return $salt . "#" . md5($salt . "#" . $secret);
    }
}