<?php
namespace WBlib;

use WBlib\Error\Error;

class ParamsChecker
{
    const HEADERS = 'headers';
    const DATA = 'data';

    public static function Existance($conf, $returnResult = false)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            foreach ($conf as $rule_key => $rule) {
                foreach ($rule as $param) {
                    if ($rule_key === static::HEADERS) {
                        if (!array_key_exists($param, $_SERVER)) {
                            if ($returnResult) {
                                return true;
                            } else {
                                Error::e400();
                            }
                        }
                    } else {
                        if (!array_key_exists($param, $_GET)) {
                            if ($returnResult) {
                                return true;
                            } else {
                                Error::e400();
                            }
                        }
                    }
                }
            }
        } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($_SERVER["CONTENT_TYPE"] === 'application/json') {
                $postData = file_get_contents('php://input');
                $data = json_decode($postData, true);

                $_POST = $data;
            }

            foreach ($conf as $rule_key => $rule) {
                foreach ($rule as $param) {
                    if ($rule_key === static::HEADERS) {
                        if (!array_key_exists($param, $_SERVER)) {
                            if ($returnResult) {
                                return true;
                            } else {
                                Error::e400();
                            }
                        }
                    } else {
                        if (!array_key_exists($param, $_POST)) {
                            if ($returnResult) {
                                return true;
                            } else {
                                Error::e400();
                            }
                        }
                    }
                }
            }
        }
    }
}