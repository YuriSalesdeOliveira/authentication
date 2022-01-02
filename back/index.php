<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

session_start();

use CoffeeCode\Router\Router;

require_once(__DIR__ . '/vendor/autoload.php');

$router = new Router(SITE['root']);

$router->namespace('Source\Http\Controllers\Api');
$router->group('/api');

$router->post('/login', 'Login:login', 'login.login');
$router->get('/login/logged', 'Login:logged', 'login.logged');
$router->get('/login/logout', 'Login:logout', 'login.logout');

$router->get('/users', 'User:users', 'user.users');
$router->get('/users/{id}', 'User:user', 'user.user');

$router->group(null);
$router->get('/oops/{error_code}', 'App:error', 'app.error');

$router->dispatch();
