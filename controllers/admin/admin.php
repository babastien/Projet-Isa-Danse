<?php

// Admin page
if($_SESSION['user']['role'] !== 'admin') {
    http_response_code(404);
    echo 'Erreur 404 : Page introuvable';
    exit;
}

use App\Model\GiftModel;
use App\Model\PackModel;
use App\Model\UserModel;
use App\Model\VideoModel;

use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;

$userModel = new UserModel();
$giftModel = new GiftModel();
$packModel = new PackModel();
$videoModel = new VideoModel();

// Show packs list for gift card
$packs = $packModel->getAllPacks();

// Show users list
$users = $userModel->getAllUsers();

// // Send a gift card
// if(isset($_POST['submit-gift'])) {
    
//     $email = trim(strip_tags($_POST['email']));
//     $idPackSelected = $_POST['pack'];
//     $errors = [];

//     if(empty($email)) {
//         $errors['email'] = 'Veuillez entrer votre adresse email';
//     } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
//         $errors['email'] = 'Le format de l\'email est invalide';
//     } elseif($userModel->verifyEmailExist($email) == false) {
//         $errors['email'] = 'Cette adresse email n\'est pas enregistrée';
//     }

//     if(empty($errors)) {

//         $gift_code = '';

//         for($i=0; $i<8; $i++) {
//             $gift_code .= mt_rand(0,9);
//         }
    
//         $giftModel->createGiftCode('Isabelle', $gift_code, $idPackSelected);

//         $user = $userModel->getUserByEmail($email);

//         if($userModel->verifyUserGetPack($user['id'], $idPackSelected) == true) {
//             $errors['user_pack'] = 'L\'utilisateur a déjà ce pack';

//         } else {

//             $message = '<p>Bonjour' . $user['firstname'] . ',</p>
//             <p>Voici une carte cadeau :)</p>
//             <p>Code cadeau : '. $gift_code .'</p>';

//             $transport = Transport::fromDsn(MAILER_DSN);
//             $mailer = new Mailer($transport);
        
//             $objEmail = (new Email())
//                 ->from('Isa-Danse')
//                 ->to($email)
//                 ->subject('Carte cadeau')
//                 ->html($message);
        
//             $mailer->send($objEmail);
        
//             header('Location: ' . constructUrl('admin'));
//             exit;
//         }
//     }
// }

// Create new pack
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
    }

    if(empty($errors)) {

        $packModel->createNewPack($title, $price, $image);
        header('Location: '. $_SERVER['REQUEST_URI']);
        exit;
    }
}

$template = 'admin/admin';
include '../templates/base.phtml';