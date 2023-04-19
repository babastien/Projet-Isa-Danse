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

        if(!empty($password) || !empty($new_password) || !empty($new_password2)) {

            if(password_verify($password, $_SESSION['password'])) {

                if($new_password == $new_password2) {

                    if(strlen($new_password) < 8) {
                        $password_errors = 'Votre mot de passe doit contenir au moins 8 caractères';
                    } elseif(!preg_match('#^[a-zA-Z0-9]$#', $new_password)) {
                        $password_errors = 'Votre mot de passe doit contenir au moins une majuscule, une minuscule et un chiffre';
                    } else {

                        $new_password = password_hash($new_password, PASSWORD_DEFAULT);
            
                        $userModel->updateUserPassword($_SESSION['email'], $new_password);
            
                        $_SESSION['password_changed'] = 'Mot de passe modifié avec succès';
        
                        header('Location: ' . constructUrl('/profile'));
                    }

                } else {
                    $password_errors = 'Les mots de passe ne correspondent pas';
                }
            } else {
                $password_errors = 'Votre mot de passe actuel ne correspond pas';
            }
        } else {
            $password_errors = 'Veuillez remplir tous les champs';
        }
    } else {
        $password_errors = 'Veuillez remplir tous les champs';
    }
}

// Formulaire de code cadeau
if(isset($_POST['code-submit']) AND !empty($_POST['code-submit'])) {

    $code = $_POST['gift-code'];
    $gift_code = $giftModel->getGiftCodeDatas($code);

    if($gift_code AND $gift_code['code'] == $code) {

        if($gift_code['used'] == 0) {

            $packModel->addPackToUser($_SESSION['id'], $gift_code['pack_id']);
            $giftModel->validGiftCode($code);

            $userPacks = $userModel->getUserPacks($_SESSION['id']);
        
            $_SESSION['packs'] = $userPacks;

        } else {
            $code_errors = 'Ce code a déjà été utilisé';
        }
    } else {
        $code_errors = 'Code erroné';
    }
}

$template = 'profile';
include '../templates/base.phtml';