<?php
use WBlib\Error\Error;
use WBlib\Settings;

class RD
{
    public static $conn;

    public static function create($returnResult = false)
    {
        try {
            static::$conn = new Redis();

            static::$conn->connect(Settings::redisConnectionString, Settings::redisConnectionNumber, 2);
            static::$conn->auth(Settings::redisPassword);

            static::$conn->ping();

            if ($returnResult) {
                return true;
            }
        } catch (Throwable $e) {
            if (!$returnResult) {
                if (hash_equals($e->getMessage(), "AUTH failed while reconnecting")) {
                    Error::e503("Oops... Seems that server is overloaded, try again later!");
                }
    
                Error::e500();
            } else {
                return false;
            }
        }
    }
    public static function setValue($key, $value, $prefix, $returnResult = false) {
        try {
            static::$conn->set($prefix . $key, $value);

            if ($returnResult) {
                return true;
            }
        } catch (Throwable $th) {
            if (!$returnResult) {
                Error::e500();
            } else {
                return false;
            }
        }
    }
    public static function getValue($key, $prefix, $returnResult = false) {
        try {
            return static::$conn->get($prefix . $key);
        } catch (Throwable $th) {
            if (!$returnResult) {
                Error::e500();
            } else {
                return false;
            }
        }
    }
    public static function deleteValue($key, $prefix, $returnResult = false) {
        try {
            static::$conn->del($prefix . $key);

            if ($returnResult) {
                return true;
            }
        } catch (Throwable $th) {
            if (!$returnResult) {
                Error::e500();
            } else {
                return false;
            }
        }
    }
    public static function close($returnResult = false)
    {   
        try {
            static::$conn->close();
            static::$conn = null;

            if ($returnResult) {
                return true;
            }
        } catch (Throwable $th) {
            static::$conn = null;
            
            if (!$returnResult) {
                Error::e500();
            } else {
                return false;
            }
        }
    }
}
