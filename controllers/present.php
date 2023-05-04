<?php

use App\Model\GiftModel;
use App\Model\PackModel;

use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;

$packModel = new PackModel();
$giftModel = new GiftModel();

// Show packs list for gift card
$packSelection = $packModel->getAllPacks();

if(!empty($_POST)) {

    $lastname = trim(strip_tags($_POST['lastname']));
    $firstname = trim(strip_tags($_POST['firstname']));
    $email = trim(strip_tags($_POST['email']));
    $email2 = trim(strip_tags($_POST['email2']));
    $idPackSelected = $_POST['pack'];

    $errors = validPresentForm($lastname, $firstname, $email, $email2);

    if(empty($errors)) {

        $gift_code = '';
        
        for($i=0; $i<8; $i++) {
            $gift_code .= mt_rand(0,9);
        }

        $giftModel->createGiftCode($email, $gift_code, $idPackSelected);

        $message = '<p>Bonjour, ' . $firstname . '</p>
        <p>Voici la carte cadeau à transférer :)</p>
        <p>Code cadeau : '. $gift_code .'</p>
        <img src="https://static.vecteezy.com/ti/vecteur-libre/p3/6748641-realiste-3d-cadeau-boite-sur-blanc-illustrationle-gratuit-vectoriel.jpg" width="100px">';

        $transport = Transport::fromDsn(MAILER_DSN);
        $mailer = new Mailer($transport);

        $objEmail = (new Email())
            ->from($email)
            ->to($email)
            ->subject('Carte cadeau')
            ->html($message);

        $mailer->send($objEmail);

        header('Location: ' . constructUrl('home'));
        exit;
    }
}

$template = 'present';
include '../templates/base.phtml';