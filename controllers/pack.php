<?php

// Need to be logged to access this page
if(!isset($_SESSION['id'])) {
    http_response_code(404);
    echo 'Erreur 404 : Page introuvable';
    exit;
}

use App\Model\UserModel;
use App\Model\PackModel;
use App\Model\VideoModel;

$userModel = new UserModel();
$packModel = new PackModel();
$videoModel = new VideoModel();

// Verify if user get pack(s)
$userPacks = $userModel->getUserPacks($_SESSION['id']);
if(empty($userPacks)) {
    header('Location: ' . constructUrl('member'));
}

foreach($userPacks as $pack) {
    if($pack['id'] == $_GET['id']) {

        // Show the title pack
        $pack = $packModel->getPackById($_GET['id']);

        // Show the pack'video(s)
        $videos = $videoModel->getVideosByPack($_GET['id']);
    }
}

$template = 'pack';
include '../templates/base.phtml';