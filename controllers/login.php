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
if(isset($_SESSION['id'])) {
    header('Location: ' . constructUrl('home'));
    exit;
}

if(isset($_POST) AND !empty($_POST)) {

    $email_login = $_POST['email-login'];
    $password_login = $_POST['password-login'];
    $success = '';

    $errors = validLoginForm($email_login, $password_login);

    if(empty($errors) AND !empty($email_login) AND !empty($password_login)) {

        $user = $userModel->getUser($email_login);

        if($user) {
            $password_user = $user['password'];

            if(password_verify($password_login, $password_user)) {
                
                $_SESSION['id'] = $user['id'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['firstname'] = $user['firstname'];
                $_SESSION['lastname'] = $user['lastname'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['password'] = $user['password'];
                
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