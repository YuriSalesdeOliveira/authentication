<?php

return
[
    'paths' => [
        'migrations' => '%%PHINX_CONFIG_DIR%%/source/DataBase/migrations',
        'seeds' => '%%PHINX_CONFIG_DIR%%/source/DataBase/seeds'
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_environment' => 'development',
        'production' => [
            'adapter' => 'mysql',
            'host' => 'localhost',
            'name' => 'production_db',
            'user' => 'root',
            'pass' => '',
            'port' => '3306',
            'charset' => 'utf8',
        ],
        'development' => [
            'adapter' => dataBaseConfig('development')['driver'],
            'host' => dataBaseConfig('development')['host'],
            'name' => dataBaseConfig('development')['dbname'],
            'user' => dataBaseConfig('development')['username'],
            'pass' => dataBaseConfig('development')['password'],
            'port' => dataBaseConfig('development')['port'],
            'charset' => dataBaseConfig('development')['charset'],
        ],
        'testing' => [
            'adapter' => 'mysql',
            'host' => 'localhost',
            'name' => 'testing_db',
            'user' => 'root',
            'pass' => '',
            'port' => '3306',
            'charset' => 'utf8',
        ]
    ],
    'version_order' => 'creation'
];
