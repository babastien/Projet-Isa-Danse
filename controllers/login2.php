<?php

use App\Model\UserModel;

$userModel = new UserModel();

$new_user = null;
if(array_key_exists('new_user', $_SESSION) AND $_SESSION['new_user']) {
    $new_user = $_SESSION['new_user'];
    $_SESSION['new_user'] = null;
    session_unset();
}

// Formulaire de connexion
if(isset($_POST['login-submit']) AND !empty($_POST['login-submit'])) {

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

                $userPacks = $userModel->getUserPacks($user['id']);

                if(!empty($userPacks)) {
                    $_SESSION['packs'] = $userPacks;
                } else {
                    $_SESSION['packs'] = [];
                }
                
                header('Location: ' . constructUrl('/'));
                exit;

            } else {
                $errors['password_login'] = 'Mauvais email ou mot de passe';
            }
        } else {
            $errors['password_login'] = 'Mauvais email ou mot de passe';
        }
    }
}

// Formulaire d'inscription
if(isset($_POST['register-submit']) AND !empty($_POST['register-submit'])) {

    $lastname = trim(ucfirst(htmlspecialchars($_POST['lastname'])));
    $firstname = trim(ucfirst(htmlspecialchars($_POST['firstname'])));
    $email = trim(strtolower(htmlspecialchars($_POST['email'])));
    $password = $_POST['password'];
    $password2 = $_POST['password2'];

    $errors = validRegisterForm($lastname, $firstname, $email, $password, $password2);

    if(!$errors) {

        $password = password_hash($password, PASSWORD_DEFAULT);

        $userModel->addNewUser($lastname, $firstname, $email, $password);

        $_SESSION['new_user'] = 'Votre compte a bien été créé';
        header('Location: ' . constructUrl('/login'));
    }
}

if(isset($_POST['register-submit'])) {
    $_SESSION['show_register'] = true;
} else {
    $_SESSION['show_register'] = false;
}

$template = 'login2';
include '../templates/base.phtml';