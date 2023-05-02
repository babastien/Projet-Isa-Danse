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
    'contact' => [
        'path' => '/contact',
        'controller' => '/contact.php'
    ],
    'admin' => [
        'path' => '/admin',
        'controller' => '/admin/admin.php'
    ],
    'edit-user' => [
        'path' => '/edit-user',
        'controller' => '/admin/editUser.php'
    ],
    'edit-pack' => [
        'path' => '/edit-pack',
        'controller' => '/admin/editPack.php'
    ],
    'edit-homepage' => [
        'path' => '/edit-homepage',
        'controller' => '/admin/editHomepage.php'
    ]
];

return $routes;