<?php

use App\Model\UserModel;
use App\Model\ForgotPasswordModel;

$userModel = new UserModel();
$passwordModel = new ForgotPasswordModel();

if(isset($_GET['section'])) {
    $section = htmlspecialchars($_GET['section']);
} else {
    $section = '';
}

// First form : enter the email
if(isset($_POST['recup-submit'])) {

    if(!empty($_POST['email'])) {

        $email = htmlspecialchars($_POST['email']);

        if(filter_var($email, FILTER_VALIDATE_EMAIL)) {

            $userExist = $userModel->verifyEmailExist($email);

            if($userExist == true) {

                $recup_code = '';

                for($i=0; $i<8; $i++) {
                    $recup_code .= mt_rand(0,9);
                }
                
                $_SESSION['recup_code'] = $recup_code;
                $_SESSION['recup_email'] = $email;

                if($passwordModel->verifiyEmailForgotPassword($email) == true) {

                    $passwordModel->updateRecupCode($email, $recup_code);
                } else {
                    $passwordModel->insertRecupCode($email, $recup_code);
                }

                $header = 'MIME-Version: 1.0\r\n';
                $header.= 'From: "IsaDanse" <support@isa.fr>'.'\n';
                $header.= 'Content-Type: text/html; charset="utf_8"'.'\n';
                $header.= 'Content-Transfer-Encoding: 8bit';

                $message = '<p>Bonjour,</p>
                <p>Voici votre code de récupération : ' . $recup_code . '</p>';
                
                // Send recuperation code by email
                mail($email, 'Récupération du mot de passe', $message, $header);

                // Redirect to the second form (same page)
                header('Location: ' . constructUrl('forgot-password', ['section' => 'code']));
                exit;

            } else {
                $errors = 'Cette adresse email n\'est pas enregistrée';
            }
        } else {
            $errors = 'Adresse email invalide';
        }
    } else {
        $errors = 'Veuillez entrer votre adresse email';
    }
}

// Second form : enter the recuperation code
if(isset($_POST['verif-submit'], $_POST['verif-code'])) {

    if(!empty($_POST['verif-code'])) {

        $verif_code = htmlspecialchars($_POST['verif-code']);

        if($passwordModel->verifyCodeExist($_SESSION['recup_email']) == true) {

            if($verif_code == $_SESSION['recup_code']) {

                $passwordModel->confirmCode($_SESSION['recup_email']);
                
                // Redirect to the third form (same page);
                header('Location: ' . constructUrl('forgot-password', ['section' => 'changepassword']));
                exit;

            } else {
                $errors = 'Code invalide';
            }    
        } else {
        $errors = 'Code invalide';
        }
    } else {
        $errors = 'Veuillez entrer votre code de vérification';
    }
}

// Third form : choose your new password
if(isset($_POST['change-submit'])) {

    if(isset($_POST['new-password'], $_POST['new-password2'])) {

        $confirmationCode = $passwordModel->getCodeConfirmation($_SESSION['recup_email']);

        if($confirmationCode['confirmation'] == 1) {

            $new_password = htmlspecialchars($_POST['new-password']);
            $new_password2 = htmlspecialchars($_POST['new-password2']);

            if(!empty($new_password) || !empty($new_password2)) {

                if($new_password == $new_password2) {

                    if(strlen($new_password) < 8) {
                        $errors = 'Votre mot de passe doit contenir au moins 8 caractères';
                    } elseif(!preg_match('/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{8,}$/', $new_password)) {
                        $errors = 'Votre mot de passe doit contenir au moins une majuscule, une minuscule et un chiffre';
                    } else {

                        $new_password = password_hash($new_password, PASSWORD_DEFAULT);
        
                        $userModel->updateUserPassword($_SESSION['recup_email'], $new_password);
                        $passwordModel->deleteForgetPasswordRequest($_SESSION['recup_email']);

                        session_destroy();
        
                        header('Location: ' . constructUrl('login'));
                        exit;
                    }

                } else {
                    $errors = 'Les mots de passe ne correspondent pas';
                }
            } else {
                $errors = 'Veuillez remplir tous les champs';
            }
        } else {
            $errors = 'Veuillez valider votre email grâce au code de vérification qui vous a été envoyé par email';
        }
    } else {
        $errors = 'Veuillez remplir tous les champs';
    }
}

$template = 'forgotPassword';
include '../templates/base.phtml';