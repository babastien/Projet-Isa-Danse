<?php

session_start();

require '../vendor/autoload.php';

require '../app/config.php';

require '../lib/functions.php';

// Récupération du path
$path = str_replace(BASE_URL, '', $_SERVER['REQUEST_URI']);
$path = str_replace('/index.php', '', $path);
$path = explode('?', $path)[0];

if ($path == '') {
    $path = '/';
}

// Routing
switch($path) {
    case '/':
        require '../controllers/home.php';
        break;
    
    case '/login2':
        require '../controllers/login2.php';
        break;

    case '/login':
        require '../controllers/login.php';
        break;
    case '/register':
        require '../controllers/register.php';
        break;

    case '/logout':
        require '../controllers/logout.php';
        break;

    case '/forgot-password':
        require '../controllers/forgotPassword.php';
        break;

    case '/profile':
        require '../controllers/profile.php';
        break;

    case '/member':
        require '../controllers/member.php';
        break;

    case '/pack':
        require '../controllers/pack.php';
        break;

    case '/purchase':
        require '../controllers/purchase.php';
        break;
        
    case '/present':
        require '../controllers/present.php';
        break;

    case '/admin':
        require '../controllers/admin.php';
        break;

    case '/edit-user';
        require '../controllers/editUser.php';
        break;

    case '/delete-user';
        require '../controllers/deleteUser.php';
        break;

    case '/edit-pack';
        require '../controllers/editPack.php';
        break;
    
    default:
        http_response_code(404);
        echo 'Erreur 404 : Page introuvable';
        exit;
}