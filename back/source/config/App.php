<?php

define('DEVELOPMENT', $_SERVER['SERVER_NAME'] === 'localhost' ? true : false);

define('LANGUAGE', 'pt-br');

define('SITE', [
    'root' => 'http://localhost/authentication/back'
]);

define('PATH', [
    'public' => '',
    'view' => '',
    'cache' => '',
    'language' => dirname(__DIR__) . '/language',
    'config' => '',
    'storage' => dirname(__DIR__) . '/storage',
]);

define('MESSAGES_FILE_PATH', sprintf(PATH['language'] . '/%s/validation.php', LANGUAGE));

define("DATA_BASE_CONFIG", [

    'default_environment' => 'development',

    // Environments
    'production' => [
        'driver' => '',
        'host' => '',
        'port' => '',
        'dbname' => '',
        'charset' => '',
        'username' => '',
        'password' => '',
        'options' => [
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_CASE => PDO::CASE_NATURAL
        ]
    ],
    'development' => [
        'driver' => 'mysql',
        'host' => 'db',
        'port' => '3306',
        'dbname' => 'authentication',
        'charset' => 'utf8',
        'username' => 'root',
        'password' => 'root',
        'options' => [
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_CASE => PDO::CASE_NATURAL
        ]
    ],
    'testing' => [
        'driver' => '',
        'host' => '',
        'port' => '',
        'dbname' => '',
        'charset' => '',
        'username' => '',
        'password' => '',
        'options' => [
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_CASE => PDO::CASE_NATURAL
        ]
    ]
]);