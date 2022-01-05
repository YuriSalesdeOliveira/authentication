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

$router->get('/users', 'User:index', 'user.index');
$router->post('/users', 'User:store', 'user.store');
$router->get('/users/{id}', 'User:show', 'user.show');
$router->post('/users/{id}', 'User:update', 'user.update');
$router->delete('/users/{id}', 'User:destroy', 'user.destroy');

$router->group(null);
$router->get('/oops/{error_code}', 'App:error', 'app.error');

$router->dispatch();

// GET	        /photos	                index	    photos.index
// GET	        /photos/create	        create	    photos.create   -
// POST	        /photos	                store	    photos.store
// GET	        /photos/{photo}	        show	    photos.show
// GET	        /photos/{photo}/edit	edit	    photos.edit     -
// PUT/PATCH	/photos/{photo}	        update	    photos.update
// DELETE	    /photos/{photo}	        destroy	    photos.destroy
