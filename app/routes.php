<?php

$routes = [
    'home' => [
        'path' => '/',
        'controller' => '/home.php'
    ],
    'login' => [
        'path' => '/login',
        'controller' => '/login.php'
    ],
    'register' => [
        'path' => '/register',
        'controller' => '/register.php'
    ],
    'logout' => [
        'path' => '/logout',
        'controller' => '/logout.php'
    ],
    'forgot-password' => [
        'path' => '/forgot-password',
        'controller' => '/forgotPassword.php'
    ],
    'profile' => [
        'path' => '/profile',
        'controller' => '/profile.php'
    ],
    'member' => [
        'path' => '/member',
        'controller' => '/member.php'
    ],
    'pack' => [
        'path' => '/pack',
        'controller' => '/pack.php'
    ],
    'purchase' => [
        'path' => '/purchase',
        'controller' => '/purchase.php'
    ],
    'present' => [
        'path' => '/present',
        'controller' => '/present.php'
    ],
    'admin' => [
        'path' => '/admin',
        'controller' => '/admin.php'
    ],
    'edit-user' => [
        'path' => '/edit-user',
        'controller' => '/editUser.php'
    ],
    'delete-user' => [
        'path' => '/delete-user',
        'controller' => '/deleteUser.php'
    ],
    'edit-pack' => [
        'path' => '/edit-pack',
        'controller' => '/editPack.php'
    ],
    'contact' => [
        'path' => '/contact',
        'controller' => '/contact.php'
    ],
    'edit-homepage' => [
        'path' => '/edit-homepage',
        'controller' => '/editHomepage.php'
    ]
];

return $routes;