<?php

use App\Model\UserModel;

$userModel = new UserModel();

// Flash message
$new_user = null;
if(array_key_exists('new_user', $_SESSION) AND $_SESSION['new_user']) {
    $new_user = $_SESSION['new_user'];
    $_SESSION['new_user'] = null;
    session_unset();
}

// Redirect to homepage if already logged
if(isset($_SESSION['user'])) {
    header('Location: ' . constructUrl('home'));
    exit;
}

if(!empty($_POST)) {

    $email_login = $_POST['email-login'];
    $password_login = $_POST['password-login'];
    $success = '';

    $errors = validLoginForm($email_login, $password_login);

    if(empty($errors)) {

        $user = $userModel->getUserByEmail($email_login);

        if($user) {
            $password_user = $user['password'];

            if(password_verify($password_login, $password_user)) {
                
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'role' => $user['role'],
                    'firstname' => $user['firstname'],
                    'lastname' => $user['lastname'],
                    'email' => $user['email'],
                    'password' => $user['password']
                ];
                
                header('Location: ' . constructUrl('home'));
                exit;

            } else {
                $errors['password_login'] = 'Mauvais email ou mot de passe';
            }
        } else {
            $errors['password_login'] = 'Mauvais email ou mot de passe';
        }
    }
}

$template = 'login';
include '../templates/base.phtml';