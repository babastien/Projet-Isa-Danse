<?php

namespace App\Controller;

use App\Core\AbstractController;
use App\Model\UserModel;
use App\Model\ForgotPasswordModel;

use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;

class ForgotPasswordController extends AbstractController {

    public function forgotPassword()
    {
        $userModel = new UserModel();
        $passwordModel = new ForgotPasswordModel();

        // Redirect to homepage if already logged
        if (isset($_SESSION['user'])) {
            header('Location: ' . constructUrl('home'));
            exit;
        }

        // Show form depending on $_GET['section]
        if (isset($_GET['section'])) {
            $section = htmlspecialchars($_GET['section']);
        } else {
            $section = '';
        }

        $errors = [];

        // First form : enter the email
        if (isset($_POST['recup-submit'])) {

            $email = $_POST['email'];

            if (empty($email)) {
                $errors['email'] = 'Veuillez entrer votre adresse email';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = 'Le format de l\'email est invalide';
            } elseif ($userModel->verifyEmailExist($email) == false) {
                $errors['email'] = 'Cette adresse email n\'est pas enregistrée';
            }

            if (empty($errors)) {
                $recup_code = '';

                for ($i=0; $i<8; $i++) {
                    $recup_code .= mt_rand(0,9);
                }
                $_SESSION['recup_code'] = $recup_code;
                $_SESSION['recup_email'] = $email;

                if ($passwordModel->verifiyEmailForgotPassword($email) == true) {
                    $passwordModel->updateRecupCode($email, $recup_code);
                } else {
                    $passwordModel->insertRecupCode($email, $recup_code);
                }
                
                $message = '<p>Bonjour,</p>
                <p>Voici votre code de récupération : ' . $recup_code . '</p>';

                $transport = Transport::fromDsn(MAILER_DSN);
                $mailer = new Mailer($transport);

                $objEmail = (new Email())
                    ->from(ADMIN_EMAIL)
                    ->to($email)
                    ->subject('Récupération du mot de passe')
                    ->html($message);

                $mailer->send($objEmail);

                // Redirect to the second form (same page)
                header('Location: ' . constructUrl('forgot-password', ['section' => 'code']));
                exit;
            }
        }

        // Second form : enter the recuperation code
        if (isset($_POST['verif-submit'])) {

            $verif_code = $_POST['verif-code'];

            if (empty($verif_code)) {
                $errors['code'] = 'Veuillez entrer le code de récupération';
            } elseif ($passwordModel->verifyCodeExistsByEmail($_SESSION['recup_email']) == false) {
                $errors['code'] = 'Code invalide';
            } elseif ($verif_code != $_SESSION['recup_code']) {
                $errors['code'] = 'Code invalide';
            }

            if (empty($errors)) {
                $passwordModel->confirmCode($_SESSION['recup_email']);
                        
                // Redirect to the third form (same page);
                header('Location: ' . constructUrl('forgot-password', ['section' => 'changepassword']));
                exit;
            }
        }

        // Third form : choose your new password
        if (isset($_POST['change-submit'])) {

            $new_password = $_POST['new-password'];
            $new_password2 = $_POST['new-password2'];
            $confirmationCode = $passwordModel->getCodeConfirmation($_SESSION['recup_email']);

            if ($confirmationCode['confirmation'] != 1) {
                $confirmation = false;
            } else {

                if (empty($new_password)) {
                    $errors['new_password'] = 'Veuillez entrer un nouveau mot de passe';
                } elseif (strlen($new_password) < 8) {
                    $errors['new_password'] = 'Votre mot de passe doit contenir au moins 8 caractères';
                } elseif (!preg_match('/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{8,}$/', $new_password)) {
                    $errors['new_password'] = 'Votre mot de passe doit contenir au moins une majuscule, une minuscule et un chiffre';
                }
    
                if (empty($new_password2)) {
                    $errors['new_password2'] = 'Veuillez confirmer votre nouveau mot de passe';
                } elseif ($new_password != $new_password2) {
                    $errors['new_password2'] = 'Les mots de passe ne correspondent pas';
                }
    
                if (empty($errors)) {
                    $new_password = password_hash($new_password, PASSWORD_DEFAULT);
                    
                    $userModel->updateUserPassword($_SESSION['recup_email'], $new_password);
                    $passwordModel->deleteForgetPasswordRequest($_SESSION['recup_email']);
    
                    session_destroy();
                    header('Location: ' . constructUrl('login'));
                    exit;
                }
            }
        }

        return $this->render('forgotPassword', [
            'section' => $section,
            'confirmation' => $confirmation,
            'errors' => $errors
        ]);
    }
}