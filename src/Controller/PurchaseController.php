<?php

namespace App\Controller;

use App\Model\PackModel;
use App\Model\UserModel;

class PurchaseController {

    function purchase()
    {
        $userModel = new UserModel();
        $packModel = new PackModel();

        // Flash message
        $new_user = null;
        if(array_key_exists('new_user', $_SESSION) AND $_SESSION['new_user']) {
            $new_user = $_SESSION['new_user'];
            $_SESSION['new_user'] = null;
            session_unset();
        }

        // Verify url/if the pack exists
        if(!array_key_exists('id', $_GET) || $packModel->verifyPackExists($_GET['id']) != true) {
            http_response_code(404);
            echo 'Erreur 404 : Page introuvable';
            exit;
        }

        // Verify if user already get this pack
        if(isset($_SESSION['user']['id'])) {
            $packAlreadyPurchased = $userModel->verifyUserGetPack($_SESSION['user']['id'], $_GET['id']);
        }

        // Show selected pack
        $packSelected = $packModel->getPackById($_GET['id']);

        // Login form
        if(isset($_POST['login-submit'])) {

            $email_login = $_POST['email-login'];
            $password_login = $_POST['password-login'];

            $errors = validLoginForm($email_login, $password_login);

            if(empty($errors) AND !empty($email_login) AND !empty($password_login)) {

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
        if(isset($_POST['register-submit'])) {

            $lastname = trim(strip_tags($_POST['lastname']));
            $firstname = trim(strip_tags($_POST['firstname']));
            $email = trim(strtolower(strip_tags($_POST['email'])));
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
        if(isset($_POST['buy-submit'])) {

            $idPackSelected = $_GET['id'];
            
            $packModel->addPackToUser($_SESSION['user']['id'], $idPackSelected);

            header('Location: ' . constructUrl('home'));
            exit;
        }

        $template = 'purchase';
        include '../templates/base.phtml';
    }
}