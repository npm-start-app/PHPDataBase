<?php

use WBlib\Error\Error;

class Roles
{
    const USER = 'User';
    const TRUSTFUL_USER = 'Trustful User';
    const ADMIN = 'Admin';

    public static function role($role)
    {
        $Roots = [
            static::USER => 0,
            static::TRUSTFUL_USER => 50,
            static::ADMIN => 100
        ];

        return $Roots[$role];
    }

    public static function tokenGenerationRoots($tokenType, $roots)
    {
        $Roots = [
            static::USER . ' Token' => 50,
            static::TRUSTFUL_USER . ' Token' => 100,
            static::ADMIN . ' Token' => 100
        ];

        if ($roots < $Roots[$tokenType]) {
            return false;
        }

        return true;
    }

    public static function getTokenGenerationRole($tokenType) {
        $Roles = [
            static::USER . ' Token' => static::USER,
            static::TRUSTFUL_USER . ' Token' => static::TRUSTFUL_USER,
            static::ADMIN . ' Token' => static::ADMIN
        ];

        return $Roles[$tokenType];
    }
}
