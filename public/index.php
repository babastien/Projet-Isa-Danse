<?php

session_start();

require '../vendor/autoload.php';

require '../app/config.php';

require '../lib/functions.php';

// Path recuperation
$path = str_replace(BASE_URL, '', $_SERVER['REQUEST_URI']);
$path = str_replace('/index.php', '', $path);
$path = explode('?', $path)[0];

if ($path == '') {
    $path = '/';
}

$routes = require '../app/routes.php';
define('ROUTES', $routes);

$controller = null;

foreach($routes as $route) {
    if($path == $route['path']) {
        $controller = $route['controller'];
        break;
    }
}

if($controller == null) {
    http_response_code(404);
    echo 'Erreur 404 : Page introuvable';
    exit;
}

try {
    require '../controllers/' . $controller;
}
catch(Exception $exception) {
    echo $exception->getMessage();
    exit;
}