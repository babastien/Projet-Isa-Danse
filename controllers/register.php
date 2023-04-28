<?php

use App\Model\UserModel;

$userModel = new UserModel();

// Redirect to homepage if already logged
if(isset($_SESSION['id'])) {
    header('Location: ' . constructUrl('home'));
    exit;
}

if(isset($_POST) AND !empty($_POST)) {

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
        header('Location: ' . constructUrl('login'));
    }
}

$template = 'register';
include '../templates/base.phtml';