<?php

use App\Model\PackModel;
use App\Model\UserModel;

$userModel = new UserModel();
$packModel = new PackModel();

// Flash message
$new_user = null;
if(array_key_exists('new_user', $_SESSION) AND $_SESSION['new_user']) {
    $new_user = $_SESSION['new_user'];
    $_SESSION['new_user'] = null;
    session_unset();
}

// Verify url
$packs = $packModel->getAllPacks();
$packsId = [];
foreach($packs as $pack) {
    $packsId[] .= $pack['id'];
}
if(!in_array($_GET['id'], $packsId) || !array_key_exists('id', $_GET)) {
    header('Location: '. constructUrl('home'));
}

// Verify if user already get this pack
if(isset($_SESSION['id'])) {
    $userPacks = $userModel->getUserPacks($_SESSION['id']);
    
    foreach($userPacks as $pack) {
        if($pack['id'] == $_GET['id']) {
            $packAlreadyPurchased = true;
        }
    }
}

// Show selected pack
$packSelected = $packModel->getPackById($_GET['id']);

// Login form
if(isset($_POST['login-submit']) AND !empty($_POST['login-submit'])) {

    $email_login = $_POST['email-login'];
    $password_login = $_POST['password-login'];

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
                
                header('Location: ' . $_SERVER['REQUEST_URI']);
                exit;

            } else {
                $errors = 'Mauvais email ou mot de passe';
            }
        } else {
            $errors = 'Mauvais email ou mot de passe';
        }
    }
}

// Register form
if(isset($_POST['register-submit']) AND !empty($_POST['register-submit'])) {

    $lastname = trim(htmlspecialchars($_POST['lastname']));
    $firstname = trim(htmlspecialchars($_POST['firstname']));
    $email = trim(strtolower(htmlspecialchars($_POST['email'])));
    $password = $_POST['password'];
    $password2 = $_POST['password2'];

    $errors = validRegisterForm($lastname, $firstname, $email, $password, $password2);

    if(!$errors) {

        $password = password_hash($password, PASSWORD_DEFAULT);

        $userModel->addNewUser($lastname, $firstname, $email, $password);

        $_SESSION['new_user'] = 'Votre compte a bien été créé';
        header('Location: ' . constructUrl('purchase', ['id' => $_GET['id']]));
        exit;
    }
}

if(isset($_POST['register-submit'])) {
    $_SESSION['show_register'] = true;
} else {
    $_SESSION['show_register'] = false;
}

// Payment form
if(isset($_POST['buy-submit']) AND !empty($_POST['buy-submit'])) {

    $idPackSelected = $_GET['id'];
    
    $packModel->addPackToUser($_SESSION['id'], $idPackSelected);

    header('Location: ' . constructUrl('home'));
    exit;
}

$template = 'purchase';
include '../templates/base.phtml';