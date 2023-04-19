<?php

use App\Model\PackModel;
use App\Model\UserModel;

if(!isset($_GET['id'])) {
    header('Location: home.php');
}

$userModel = new UserModel();
$packModel = new PackModel();

// Affiche le cours sélectionné
if(isset($_GET['id'])) {
    $packSelected = $packModel->getOnePack($_GET['id']);
}

// Formulaire de connexion
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

                $userCourses = $userModel->getUserPacks($user['id']);

                if(!empty($userPacks)) {
                    $_SESSION['packs'] = $userPacks;
                } else {
                    $_SESSION['packs'] = [];
                }
                
                header('Location: ' . constructUrl('/purchase', ['id' => $_GET['id']]));
                exit;

            } else {
                $errors = 'Mauvais email ou mot de passe';
            }
        } else {
            $errors = 'Mauvais email ou mot de passe';
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
        header('Location: ' . constructUrl('/purchase', ['id' => $_GET['id']]));
        exit;
    }
}

if(isset($_POST['register-submit'])) {
    $_SESSION['show_register'] = true;
} else {
    $_SESSION['show_register'] = false;
}

// Formulaire de paiement
if(isset($_POST['buy-submit']) AND !empty($_POST['buy-submit'])) {

    $idPackSelected = $_GET['id'];
    
    // Ajoute un cours à l'utilisateur
    $packModel->addPackToUser($_SESSION['id'], $idPackSelected);

    $userCourses = $userModel->getUserPacks($_SESSION['id']);

    $_SESSION['packs'] = $userPacks;

    header('Location: ' . constructUrl('/'));
    exit;
}

$template = 'purchase';
include '../templates/base.phtml';