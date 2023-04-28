<?php

use App\Model\PackModel;
use App\Model\GiftModel;

$packModel = new PackModel();
$giftModel = new GiftModel();

// Show packs list for gift card
$packSelection = $packModel->getAllPacks();

if(isset($_POST) AND !empty($_POST)) {

    $lastname = $_POST['lastname'];
    $firstname = $_POST['firstname'];
    $email = htmlspecialchars($_POST['email']);
    $email2 = htmlspecialchars($_POST['email2']);
    $idPackSelected = $_POST['pack'];

    $errors = validPresentForm($lastname, $firstname, $email, $email2);

    if(empty($errors)) {

        $gift_code = '';

        for($i=0; $i<8; $i++) {
            $gift_code .= mt_rand(0,9);
        }

        $giftModel->createGiftCode($email, $gift_code, $idPackSelected);

        $header = 'MIME-Version: 1.0\r\n';
        $header.= 'From: "IsaDanse" <support@isa.fr>'.'\n';
        $header.= 'Content-Type: text/html; charset="utf_8"'.'\n';
        $header.= 'Content-Transfer-Encoding: 8bit';

        $message = '<p>Bonjour,</p>
        <p>Voici la carte cadeau à transférer :)</p>
        <p>'. $gift_code .'</p>';
                
        // Send gift card by email
        mail($email, 'Carte cadeau', $message, $header);

        header('Location: ' . constructUrl('home'));
    }
}

$template = 'present';
include '../templates/base.phtml';