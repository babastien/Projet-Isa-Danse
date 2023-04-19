<?php

// Page innaccessible sans connexion
if(!isset($_SESSION['id'])) {
    http_response_code(404);
    echo 'Erreur 404 : Page introuvable';
    exit;
}

use App\Model\UserModel;

$userModel = new UserModel();

$packs = $userModel->getUserPacks($_SESSION['id']);

$template = 'member';
include '../templates/base.phtml';