<?php

use App\Model\PackModel;
use App\Model\GiftModel;
use App\Model\UserModel;

$userModel = new UserModel();
$packModel = new PackModel();
$giftModel = new GiftModel();

// Message flash lorsque le mot de passe est modifié
if(array_key_exists('password_changed', $_SESSION) AND $_SESSION['password_changed']) {
    $password_changed = $_SESSION['password_changed'];
    $_SESSION['password_changed'] = null;
}

// Formulaire de modification du mot de passe
if(isset($_POST['password-submit']) AND !empty($_POST['password-submit'])) {

    if(isset($_POST["password"], $_POST['new-password'], $_POST['new-password2'])) {

        $password = htmlspecialchars($_POST['password']);
        $new_password = htmlspecialchars($_POST['new-password']);
        $new_password2 = htmlspecialchars($_POST['new-password2']);
        $session_password = $_SESSION['password'];
        $errors = [];

        $errors = validChangePasswordForm($password, $new_password, $new_password2, $session_password);

        if(empty($errors)) {

            $new_password = password_hash($new_password, PASSWORD_DEFAULT);
            
            $userModel->updateUserPassword($_SESSION['email'], $new_password);
            
            $_SESSION['password_changed'] = 'Mot de passe modifié avec succès';
        
            header('Location: ' . $_SERVER['REQUEST_URI']);
        }
    }
}

// Formulaire de code cadeau
if(isset($_POST['code-submit']) AND !empty($_POST['code-submit'])) {

    $code = $_POST['gift-code'];

    if(!empty($code)) {

        $gift_db = $giftModel->getGiftCodeDatas($code);
    
        if($gift_db AND $gift_db['code'] == $code) {
    
            if($gift_db['used'] == 0) {
    
                $packModel->addPackToUser($_SESSION['id'], $gift_db['pack_id']);
                $giftModel->validGiftCode($code);
    
                $userPacks = $userModel->getUserPacks($_SESSION['id']);
            
                $_SESSION['packs'] = $userPacks;
    
            } else {
                $code_errors = 'Ce code a déjà été utilisé';
            }
        } else {
            $code_errors = 'Code erroné';
        }
    } else {
        $code_errors = 'Le champ est vide';
    }
}

$template = 'profile';
include '../templates/base.phtml';