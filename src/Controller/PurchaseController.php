<?php

namespace App\Controller;

use App\Core\AbstractController;
use App\Model\PackModel;
use App\Model\UserModel;

class PurchaseController extends AbstractController {

    public function purchase()
    {
        $userModel = new UserModel();
        $packModel = new PackModel();

        // Flash message
        $new_user = null;
        if (array_key_exists('new_user', $_SESSION) AND $_SESSION['new_user']) {
            $new_user = $_SESSION['new_user'];
            $_SESSION['new_user'] = null;
            session_unset();
        }

        // Verify url/if the pack exists
        if (!array_key_exists('id', $_GET) || $packModel->verifyPackExists($_GET['id']) != true) {
            http_response_code(404);
            echo 'Erreur 404 : Page introuvable';
            exit;
        }

        // Verify if user already get this pack
        if (isset($_SESSION['user']['id'])) {
            $packAlreadyPurchased = $userModel->verifyUserGetPack($_SESSION['user']['id'], $_GET['id']);
        }

        // Show selected pack
        $packSelected = $packModel->getPackById($_GET['id']);

        $errors = [];
        $email_login = '';
        $lastname = '';
        $firstname = '';
        $email = '';

        // Login form
        if (isset($_POST['login-submit'])) {

            $email_login = $_POST['email-login'];
            $password_login = $_POST['password-login'];

            $errors = validLoginForm($email_login, $password_login);

            if (empty($errors)) {

                $user = $userModel->getUserByEmail($email_login);

                if ($user AND password_verify($password_login, $user->getPassword())) {
                    
                    $_SESSION['user'] = [
                        'id' => $user->getId(),
                        'role' => $user->getRole(),
                        'firstname' => $user->getFirstname(),
                        'lastname' => $user->getLastname(),
                        'email' => $user->getEmail(),
                        'password' => $user->getPassword()
                    ];
                    
                    header('Location: ' . $_SERVER['REQUEST_URI']);
                    exit;

                } else {
                    $errors['password_login'] = 'Mauvais email ou mot de passe';
                }
            }
        }

        // Register form
        if (isset($_POST['register-submit'])) {

            $lastname = trim(strip_tags($_POST['lastname']));
            $firstname = trim(strip_tags($_POST['firstname']));
            $email = trim(strtolower(strip_tags($_POST['email'])));
            $password = $_POST['password'];
            $password2 = $_POST['password2'];

            $errors = validRegisterForm($lastname, $firstname, $email, $password, $password2);

            if (empty($errors)) {

                $password = password_hash($password, PASSWORD_DEFAULT);

                $userModel->addNewUser($lastname, $firstname, $email, $password);

                $_SESSION['new_user'] = 'Votre compte a bien été créé';
                header('Location: ' . $_SERVER['REQUEST_URI']);
                exit;
            }
        }

        if (isset($_POST['register-submit'])) {
            $_SESSION['show_register'] = true;
        } else {
            $_SESSION['show_register'] = false;
        }

        // Payment form
        if (isset($_POST['buy-submit'])) {

            $idPackSelected = $_GET['id'];
            
            $packModel->addPackToUser($_SESSION['user']['id'], $idPackSelected);

            header('Location: ' . constructUrl('home'));
            exit;
        }

        return $this->render('purchase', [
            'new_user' => $new_user,
            'packAlreadyPurchased' => $packAlreadyPurchased,
            'packSelected' => $packSelected,
            'errors' => $errors,
            'email_login' => $email_login,
            'lastname' => $lastname,
            'firstname' => $firstname,
            'email' => $email
        ]);
    }
}