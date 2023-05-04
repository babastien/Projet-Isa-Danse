<?php

// Need to be logged to access this page
if(!isset($_SESSION['user'])) {
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

// Verify url/if the pack exists
if(!array_key_exists('id', $_GET) || $packModel->verifyPackExists($_GET['id']) != true) {
    http_response_code(404);
    echo 'Erreur 404 : Page introuvable';
    exit;
}

// Verify if user get the pack
if($userModel->verifyUserGetPack($_SESSION['user']['id'], $_GET['id']) == false) {
    http_response_code(404);
    echo 'Erreur 404 : Page introuvable';
    exit;

} else {
    // Show the title pack
    $pack = $packModel->getPackById($_GET['id']);

    // Show the pack'video(s)
    $videos = $videoModel->getVideosByPack($_GET['id']);
}

$template = 'pack';
include '../templates/base.phtml';