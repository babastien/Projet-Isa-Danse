<?php

// Page réservée à l'administrateur
if($_SESSION['role'] !== 'admin') {
    http_response_code(404);
    echo 'Erreur 404 : Page introuvable';
    exit;
}

use App\Model\UserModel;
use App\Model\GiftModel;
use App\Model\PackModel;
use App\Model\VideoModel;

$userModel = new UserModel();
$giftModel = new GiftModel();
$packModel = new PackModel();
$videoModel = new VideoModel();

// Affiche la liste des cours pour envoyer une carte cadeau
$packs = $packModel->getAllPacks();

// Affiche la liste des utilisateurs
$users = $userModel->getAllUsers();

// if(isset($_POST['submit-gift']) AND !empty($_POST['submit-gift'])) {

//     $email = htmlspecialchars($_POST['email']);
//     $idPackSelected = $_POST['pack'];

//     $gift_code = '';

//     for($i=0; $i<8; $i++) {
//         $gift_code .= mt_rand(0,9);
//     }

//     $giftModel->createGiftCode('Isabelle', $gift_code, $idCourseSelected);

//     $header = 'MIME-Version: 1.0\r\n';
//     $header.= 'From: "IsaDanse" <support@isa.fr>'.'\n';
//     $header.= 'Content-Type: text/html; charset="utf_8"'.'\n';
//     $header.= 'Content-Transfer-Encoding: 8bit';

//     $message = '<p>Bonjour,</p>
//     <p>Voici une carte cadeau :)</p>
//     <p>'. $gift_code .'</p>';
                
//     // Envoi de la carte cadeau par email
//     mail($email, 'Carte cadeau', $message, $header);

//     header('Location: ' . constructUrl('/admin'));
// }

if(isset($_POST['create-pack'])) {
    $title = $_POST['title'];
    $price = $_POST['price'];
    $image = $_POST['image'];
    $errors = [];

    if(empty($title)) {
        $errors['title'] = 'Veuillez donner un titre au pack';
    }
    if(empty($price)) {
        $errors['price'] = 'Veuillez donner un prix au pack';
    }
    if(empty($image)) {
        $errors['image'] = 'Veuillez choisir une image pour le pack';
    } else {

        $packModel->createNewPack($title, $price, $image);
        header('Location: '. $_SERVER['REQUEST_URI']);
        exit;
    }
}

$template = 'admin';
include '../templates/base.phtml';