<?php

use App\Model\PackModel;
use App\Model\GiftModel;

$packModel = new PackModel();
$giftModel = new GiftModel();

// Affiche la liste des cours pour envoyer une carte cadeau
$packs = $packModel->getAllPacks();

if(isset($_POST) AND !empty($_POST)) {

    $email = htmlspecialchars($_POST['email']);
    $email2 = htmlspecialchars($_POST['email2']);
    $idPackSelected = $_POST['pack'];

    if($email == $email2) {

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
        <p>Merci pour ta jolie attention, voici la carte cadeau à transférer :)</p>
        <p>'. $gift_code .'</p>';
                
        // Envoi de la carte cadeau par email
        mail($email, 'Carte cadeau', $message, $header);

        header('Location: ' . constructUrl('/'));
    }
}

$template = 'present';
include '../templates/base.phtml';