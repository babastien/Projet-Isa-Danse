<?php

namespace App\Controller;

use App\Core\AbstractController;
use App\Model\UserModel;

class UserController extends AbstractController {

    public function register()
    {
        $userModel = new UserModel();

        // Redirect to homepage if already logged
        if (isset($_SESSION['user'])) {
            header('Location: ' . constructUrl('home'));
            exit;
        }

        $errors = [];
        $lastname = '';
        $firstname = '';
        $email = '';

        if (!empty($_POST)) {

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
                header('Location: ' . constructUrl('login'));
                exit;
            }
        }

        return $this->render('register', [
            'errors' => $errors,
            'lastname' => $lastname,
            'firstname' => $firstname,
            'email' => $email
        ]);
    }
}