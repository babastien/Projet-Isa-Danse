<?php

// Page innaccessible sans connexion
if(!isset($_SESSION['id'])) {
    http_response_code(404);
    echo 'Erreur 404 : Page introuvable';
    exit;
}

use App\Model\VideoModel;

$videoModel = new VideoModel();

$videos = $videoModel->getVideosByPack($_GET['pack']);

$template = 'pack';
include '../templates/base.phtml';