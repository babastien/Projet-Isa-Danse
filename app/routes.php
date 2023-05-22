<?php

$routes = [
    'home' => [
        'path' => '/',
        'controller' => 'HomeController',
        'method' => 'index'
    ],
    'register' => [
        'path' => '/register',
        'controller' => 'UserController',
        'method' => 'register'
    ],
    'login' => [
        'path' => '/login',
        'controller' => 'AuthController',
        'method' => 'login'
    ],
    'logout' => [
        'path' => '/logout',
        'controller' => 'AuthController',
        'method' => 'logout'
    ],
    'forgot-password' => [
        'path' => '/forgot-password',
        'controller' => 'ForgotPasswordController',
        'method' => 'forgotPassword'
    ],
    'profile' => [
        'path' => '/profile',
        'controller' => 'ProfileController',
        'method' => 'profile'
    ],
    'member' => [
        'path' => '/member',
        'controller' => 'MemberController',
        'method' => 'showPacks'
    ],
    'pack' => [
        'path' => '/member/pack',
        'controller' => 'MemberController',
        'method' => 'showPackVideos'
    ],
    'purchase' => [
        'path' => '/purchase',
        'controller' => 'PurchaseController',
        'method' => 'purchase'
    ],
    'present' => [
        'path' => '/present',
        'controller' => 'PresentController',
        'method' => 'present'
    ],
    'contact' => [
        'path' => '/contact',
        'controller' => 'ContactController',
        'method' => 'contact'
    ],
    'admin' => [
        'path' => '/admin',
        'controller' => 'Admin\\AdminDashboardController',
        'method' => 'dashboard'
    ],
    'edit-user' => [
        'path' => '/admin/edit-user',
        'controller' => 'Admin\\AdminUserController',
        'method' => 'editUser'
    ],
    'edit-pack' => [
        'path' => '/admin/edit-pack',
        'controller' => 'Admin\\AdminPackController',
        'method' => 'editPack'
    ],
    'edit-homepage' => [
        'path' => '/admin/edit-homepage',
        'controller' => 'Admin\\AdminHomepageController',
        'method' => 'editHomepage'
    ]
];

return $routes;