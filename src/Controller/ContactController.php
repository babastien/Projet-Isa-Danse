<?php

namespace App\Controller;

use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;

class ContactController {

    public function contact()
    {
        if(!empty($_POST)) {
        
            $response = [];
            $errors = [];
        
            $email = trim($_POST['email']);
            $subject = trim($_POST['subject']);
            $message = trim($_POST['message']);
        
            if(!$email) {
                $errors['email'] = 'Le champ <b>Email</b> est obligatoire';
            } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = 'Le format de l\'email est invalide';
            }
            if(!$subject) {
                $errors['subject'] = 'Le champ <b>Sujet</b> est obligatoire';
            }
            if(!$message) {
                $errors['message'] = 'Le champ <b>Message</b> est obligatoire';
            }
        
            if(empty($errors)) {
        
                $transport = Transport::fromDsn(MAILER_DSN);
                $mailer = new Mailer($transport);
        
                $objEmail = (new Email())
                    ->from($email)
                    ->to(ADMIN_EMAIL)
                    ->subject('Nouveau message : ' . $subject)
                    ->text($message);
        
                $mailer->send($objEmail);
        
                $response['success'] = 'Votre email a bien été envoyé';
        
            } else {
                $response['errors'] = $errors;
            }
        
            echo json_encode($response);
            exit;
        }
        
        $template = 'contact';
        include '../templates/base.phtml'; 
    }
}