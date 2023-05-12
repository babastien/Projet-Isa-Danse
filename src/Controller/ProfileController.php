<?php

namespace App\Controller;

use App\Model\PackModel;
use App\Model\GiftModel;
use App\Model\UserModel;

class ProfileController {

    function profile()
    {
        // Need to be logged to access this page
        if(!isset($_SESSION['user'])) {
            http_response_code(404);
            echo 'Erreur 404 : Page introuvable';
            exit;
        }

        $userModel = new UserModel();
        $packModel = new PackModel();
        $giftModel = new GiftModel();

        // Flash message
        if(array_key_exists('password_changed', $_SESSION) AND $_SESSION['password_changed']) {
            $password_changed = $_SESSION['password_changed'];
            $_SESSION['password_changed'] = null;
        }

        // Show user's pack(s)
        $userPacks = $userModel->getUserPacks($_SESSION['user']['id']);

        // Password edit form
        if(isset($_POST['password-submit'])) {

            if(isset($_POST["password"], $_POST['new-password'], $_POST['new-password2'])) {

                $password = htmlspecialchars($_POST['password']);
                $new_password = htmlspecialchars($_POST['new-password']);
                $new_password2 = htmlspecialchars($_POST['new-password2']);
                $session_password = $_SESSION['user']['password'];
                $errors = [];

                $errors = $this->validChangePasswordForm($password, $new_password, $new_password2, $session_password);

                if(empty($errors)) {

                    $new_password = password_hash($new_password, PASSWORD_DEFAULT);
                    
                    $userModel->updateUserPassword($_SESSION['user']['email'], $new_password);
                    $_SESSION['user']['password'] = $new_password;
                    
                    $_SESSION['password_changed'] = 'Mot de passe modifié avec succès';
                
                    header('Location: ' . $_SERVER['REQUEST_URI']);
                    exit;
                }
            }
        }

        // Gift code form
        if(isset($_POST['code-submit'])) {

            $code = $_POST['gift-code'];

            if(!empty($code)) {

                $gift_db = $giftModel->getGiftCodeDatas($code);
            
                if($gift_db AND $gift_db['code'] == $code) {
            
                    if($gift_db['used'] == 0) {
            
                        $packModel->addPackToUser($_SESSION['user']['id'], $gift_db['pack_id']);
                        $giftModel->validGiftCode($code);

                        header('Location: ' . $_SERVER['REQUEST_URI']);
                        exit;
            
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

        // Delete account
        if(array_key_exists('delete-password', $_POST)) {

            if(empty($_POST['delete-password'])) {
                $delete_errors = 'Le champ est vide';
            } elseif(!password_verify($_POST['delete-password'], $_SESSION['user']['password'])) {
                $delete_errors = 'Mot de passe erroné';
            }
            
            if(empty($delete_errors)) {
                $response['success'] = 'Votre compte a bien été supprimé';

                $userModel->deleteUser($_SESSION['user']['id']);
                $_SESSION['user'] = null;
                session_destroy();

            } else {
                $response['errors'] = $delete_errors;
            }
            echo json_encode($response);
            exit;
        }

        $template = 'profile';
        include '../templates/base.phtml';
    }

    public function validChangePasswordForm($password, $new_password, $new_password2, $session_password)
    {
        $errors = [];

        if(empty($password)) {
            $errors['password'] = 'Veuillez renseigner votre mot de passe actuel';
        } elseif(!password_verify($password, $session_password)) {
            $errors['password'] = 'Le mot passe actuel ne correspond pas';
        }
        if(empty($new_password)) {
            $errors['new_password'] = 'Veuillez entrer un nouveau mot de passe';
        } elseif(!preg_match('/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{8,}$/', $new_password)) {
            $errors['new_password'] = 'Le mot de passe doit contenir au moins 8 caractères dont une majuscule, une minuscule et un chiffre';
        }
        if(empty($new_password2)) {
            $errors['new_password2'] = 'Veuillez confirmer le nouveau mot de passe';
        } elseif($new_password != $new_password2) {
            $errors['new_password2'] = 'Les mots de passe ne correspondent pas';
        }

        return $errors;
    }
}