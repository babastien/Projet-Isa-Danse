<?php

use App\Model\UserModel;

if(isset($_POST) AND !empty($_POST)) {

    $lastname = htmlspecialchars($_POST['lastname']);
    $firstname = htmlspecialchars($_POST['firstname']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    $password2 = htmlspecialchars($_POST['password2']);

    $errors = validRegisterForm($lastname, $firstname, $email, $password, $password2);

    if(!$errors) {

        $password = password_hash($password, PASSWORD_DEFAULT);

        $userModel = new UserModel();
        $userModel->addUser($lastname, $firstname, $email, $password);

        $_SESSION['new_user'] = 'Votre compte a bien été créé';
        header('Location: ' . constructUrl('/login'));
    }
}

$template = 'register';
include '../templates/base.phtml';