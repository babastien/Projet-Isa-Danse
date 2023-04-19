<?php

// Page réservée à l'administrateur
if($_SESSION['role'] !== 'admin') {
    http_response_code(404);
    echo 'Erreur 404 : Page introuvable';
    exit;
}

use App\Model\PackModel;
use App\Model\VideoModel;

$packModel = new PackModel();
$videoModel = new VideoModel();

$pack = $packModel->getPackById($_GET['id']);

$videos = $videoModel->getVideosByPack($_GET['id']);

// Modifier le pack
if(isset($_POST['edit-pack'])) {
    $pack_title = $_POST['pack-title'];
    $price = $_POST['price'];
    $image = $_POST['image'];

    $packModel->editPack($_GET['id'], $pack_title, $price, $image);
    header('Location: ' . $_SERVER['REQUEST_URI']);
    exit;
}

// Modifier une vidéo
if(!empty($videos)) {
    foreach($videos as $video) {
        if(isset($_POST['edit-'.$video['id']])) {
            $videoModel->editVideo($_GET['id'], $_POST['video-title-'.$video['id']], $_POST['video-filename-'.$video['id']], $_POST['rank-order-'.$video['id']], $video['id']);
            // header('Location: ' . $_SERVER['REQUEST_URI']);
            exit;
        }
    }
}

// Supprimer une vidéo
if(!empty($videos)) {
    foreach($videos as $video) {
        if(isset($_POST['delete-'.$video['id']])) {
            $videoModel->deleteVideo($video['id']);
        header('Location: ' . $_SERVER['REQUEST_URI']);
        exit;
        }
    }
}

// Ajouter une vidéo
if(isset($_POST['add-video'])) {
    $video_title = $_POST['video-title'];
    $video_filename = $_POST['video-filename'];
    $rank_order = $_POST['rank-order'];

    if(empty($video_title) || empty($video_filename) || empty($rank_order)) {
        $errors['add-video'] = 'Vous devez remplir tous les champs';
    } else {

        $videoModel->addVideo($_GET['id'], $video_title, $video_filename, $rank_order);
        header('Location: ' . $_SERVER['REQUEST_URI']);
        exit;
    }
}

$template = 'editPack';
include '../templates/base.phtml';