<?php

namespace App\Controller;

use App\Core\AbstractController;
use App\Model\UserModel;

class AuthController extends AbstractController {
    
    public function login()
    {
        $userModel = new UserModel();

        // Flash message
        $new_user = null;
        if (array_key_exists('new_user', $_SESSION) AND $_SESSION['new_user']) {
            $new_user = $_SESSION['new_user'];
            $_SESSION['new_user'] = null;
            session_unset();
        }

        // Redirect to homepage if already logged
        if (isset($_SESSION['user'])) {
            header('Location: ' . constructUrl('home'));
            exit;
        }

        $errors = [];
        $email_login = '';

        if (!empty($_POST)) {

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
                    
                    header('Location: ' . constructUrl('home'));
                    exit;

                } else {
                    $errors['password_login'] = 'Mauvais email ou mot de passe';
                }
            }
        }

        return $this->render('login', [
            'new_user' => $new_user,
            'errors' => $errors,
            'email_login' => $email_login
        ]);
    }

    public function logout()
    {
        $_SESSION = [];
        session_destroy();
        header('Location: ' . constructUrl('home'));
        exit;
    }

}