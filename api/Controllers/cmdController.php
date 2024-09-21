<?php

use SessionData\SessionData;
use WBlib\Route;

class Cmd
{
    const driveDomain = 'https://drive-snowy.vercel.app/';

    const COMMANDS = [
        '/stats' => 'Cmd::_stats',
        '/drive' => [
            'fileList' => ['?pageSize', 'Cmd::_drive_fileList'],
            'createFile' => ['?folderId', 'Cmd::_drive_createFile'],
            'init' => 'Cmd::_drive_init',
            'checkStructure' => 'Cmd::_drive_checkStructure',
            'getFile' => ['!fileId', 'Cmd::_drive_getFile']
        ],
        '/help' => 'Cmd::_help'
    ];

    public static function _drive_getFile($params)
    {
        Route::response([
            "status" => true,
            "result" => 'Calling ' . static::driveDomain . 'drive/getFile',
            "recall" => true,
            "data" => ['fileId' => $params['fileId']],
            "method" => 'get',
            "typeData" => 'url',
            "url" => 'drive/getFile',
            "domain" => static::driveDomain,
            "file" => false,
            "headers" => [
                "driveToken" => SessionData::$userProfile['driveToken'],
                "profileId" => SessionData::$profileId
            ]
        ]);
    }

    public static function _drive_checkStructure()
    {
        Route::response([
            "status" => true,
            "result" => 'Calling ' . static::driveDomain . 'drive/checkStructure',
            "recall" => true,
            "data" => ['flag' => false, 'cmd' => true],
            "method" => 'get',
            "typeData" => 'url',
            "url" => 'drive/checkStructure',
            "domain" => static::driveDomain,
            "file" => false,
            "headers" => [
                "driveToken" => SessionData::$userProfile['driveToken'],
                "profileId" => SessionData::$profileId
            ]
        ]);
    }

    public static function _help()
    {
        $jsonString = file_get_contents(__DIR__ . '/../cmdCommands.json');

        $data = json_decode($jsonString, true);

        $_data = [3, '{', 0, 3, 3, 3, 3];

        $numItems = count($data);
        $i = 0;
        foreach ($data as $key => $value) {
            array_push($_data, [4, ['yellow', $key]], ':', 3, $value);
            if (++$i === $numItems) {
                array_push($_data, 0, 3, '}');
            } else {
                array_push($_data, 0, 3, 3, 3, 3);
            }
        }

        return $_data;
    }

    public static function _drive_init()
    {
        Route::response([
            "status" => true,
            "result" => 'Calling ' . static::driveDomain . 'init/drive',
            "recall" => true,
            "data" => ['flag' => true, 'cmd' => true],
            "method" => 'get',
            "typeData" => 'url',
            "url" => 'init/drive',
            "domain" => static::driveDomain,
            "file" => false,
            "headers" => [
                "driveToken" => SessionData::$userProfile['driveToken'],
                "profileId" => SessionData::$profileId
            ]
        ]);
    }

    public static function _drive_fileList($params)
    {
        Route::response([
            "status" => true,
            "result" => 'Calling ' . static::driveDomain . 'drive/getFileList',
            "recall" => true,
            "data" => (array_key_exists('pageSize', $params)) ? ['pageSize' => $params['pageSize'], 'cmd' => true] : ['cmd' => true],
            "method" => 'get',
            "typeData" => 'url',
            "url" => 'drive/getFileList',
            "domain" => static::driveDomain,
            "file" => false,
            "headers" => [
                "driveToken" => SessionData::$userProfile['driveToken'],
                "profileId" => SessionData::$profileId
            ]
        ]);
    }

    public static function _drive_createFile($params)
    {
        Route::response([
            'status' => true,
            'result' => 'Calling ' . static::driveDomain . 'drive/createfile',
            'recall' => true,
            'data' => (array_key_exists('folderId', $params)) ? [
                0 => 'file',
                'folderId' => $params['folderId']
            ] : [0 => 'file'],
            'method' => 'post',
            'typeData' => 'formData',
            'url' => 'drive/createFile',
            'domain' => static::driveDomain,
            'file' => true,
            "headers" => [
                "driveToken" => SessionData::$userProfile['driveToken'],
                "profileId" => SessionData::$profileId
            ]
        ]);
    }

    public static function _stats()
    {
        SessionData::$set_error_handler = false;

        $redis = 'true';
        $drive = 'true';

        $start_R = microtime(true);
        $result = RD::$conn->ping();
        $end_R = microtime(true);
        if (!$result) {
            $redis = 'false';
        }

        $start_D = microtime(true);
        $url = static::driveDomain . 'drive/ping';

        $headers = [
            'drivetoken: ' . SessionData::$userProfile['driveToken'],
            'profileid: ' . SessionData::$profileId
        ];
        $options = [
            'http' => [
                'method' => 'GET',
                'header' => implode("\r\n", $headers),
                'request_fulluri' => true,
                'mode' => 'cors',
                'cache' => 'no-cache',
                'credentials' => 'same-origin',
                'referrerPolicy' => 'no-referrer'
            ]
        ];

        $context = stream_context_create($options);
        $response = file_get_contents($url, false, $context);
        $end_D = microtime(true);
        if (!$response) {
            $drive = 'false';
        }

        SessionData::$set_error_handler = true;

        $redisMS = ($redis === 'true') ? intval(($end_R - $start_R) * 1000) . 'ms' : '-ms';
        $driveMS = ($drive === 'true') ? intval(($end_D - $start_D) * 1000) . 'ms' : '-ms';

        return [
            3,
            '{',
            0,
            3,
            3,
            3,
            3,
            'Redis - ' . $redis . ' | ' . $redisMS,
            0,
            3,
            3,
            3,
            3,
            'Google Drive - ' . $drive . ' | ' . $driveMS,
            0,
            3,
            '}'
        ];
    }

    public static function do()
    {
        $command = trim($_POST['command']);
        $result = "Such command doesn't exist.";

        $_command = explode(' ', $command);

        $_params = [];

        // var_dump($_command);

        if (array_key_exists($_command[0], static::COMMANDS)) {
            if (gettype(static::COMMANDS[$_command[0]]) === 'string') {
                $result = static::COMMANDS[$_command[0]]();
            } else {
                if (!array_key_exists(1, $_command)) {
                    $result = 'Parameters syntax error.';
                } else {
                    if (array_key_exists($_command[1], static::COMMANDS[$_command[0]])) {
                        if (gettype(static::COMMANDS[$_command[0]][$_command[1]]) === 'string') {
                            $result = static::COMMANDS[$_command[0]][$_command[1]]();
                        } else if (gettype(static::COMMANDS[$_command[0]][$_command[1]]) === 'array') {
                            $i = 2;

                            foreach (static::COMMANDS[$_command[0]][$_command[1]] as $param) {
                                if ($i > count(static::COMMANDS[$_command[0]][$_command[1]])) {
                                    $result = static::COMMANDS[$_command[0]][$_command[1]][count(static::COMMANDS[$_command[0]][$_command[1]]) - 1]($_params);

                                    break;
                                }

                                if (array_key_exists($i, $_command)) {
                                    $_param = substr($param, 1);

                                    $_params[$_param] = $_command[$i];

                                    $i++;
                                } else if ($param[0] === '?') {
                                    $i++;

                                    continue;
                                } else {
                                    return [
                                        "status" => true,
                                        "result" => 'Parameters syntax error.',
                                        "recall" => false
                                    ];
                                }
                            }
                        }
                    }
                }
            }
        }

        return [
            "status" => true,
            "result" => $result,
            "recall" => false
        ];
    }
}
